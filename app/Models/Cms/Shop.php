<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\CmsActionLogService;

/**
 * Shop
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property CmsShopRelease[] $cmsShopReleases
 * @property ShopItem[] $shopItems
 */
class Shop extends Model
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 6;

    /**
     * Possible deploy directions
     *
     * @var array
     */
    public static $deployDirections = [
        'dev-stage',
        'stage-live',
    ];

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'description',
        'available',
        'available_for_tester',
        'data',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * CmsShopRelease relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cmsShopReleases()
    {
        return $this->hasMany(CmsShopRelease::class);
    }

    /**
     * ShopItem relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopItems()
    {
        return $this->hasMany(ShopItem::class);
    }

    /**
     * Check direction
     *
     * @param string $from From direction
     * @param string $to   To direction
     *
     * @return boolean
     */
    protected function checkDirection(string $from, string $to)
    {
        return in_array("$from-$to", self::$deployDirections);
    }

    /**
     * Deploy
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     * @param array  $ids     Shops Ids
     *
     * @return boolean
     */
    public function deploy(string $fromEnv, string $toEnv, array $ids)
    {
        $status = false;
        if ($this->checkDirection($fromEnv, $toEnv)) {
            $funName = "deploy" . ucfirst($fromEnv) . ucfirst($toEnv);
            if (method_exists($this, $funName)) {
                $status = $this->{$funName};
            } else {
                $status = $this->deployDefault($fromEnv, $toEnv, $ids);
            }
        }
        return $status;
    }

    /**
     * Deploy default
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     * @param array  $ids     Shops Ids
     *
     * @return boolean
     */
    protected function deployDefault(string $fromEnv, string $toEnv, array $ids)
    {
        $status = true;
        $now    = Carbon::now();

        $destinationDatabase = DB::connection("$toEnv.cms");
        $this->setConnection("$fromEnv.cms");

        try {
            DB::connection("$toEnv.cms")->beginTransaction();

            $builder = $this->where(function ($query) {
                $query->whereRaw('deployed_at < updated_at')
                    ->orWhereNull('deployed_at');
            })->whereIn('id', $ids);

            $queryBuilder = $builder->with('shopItems');

            foreach ($queryBuilder->get() as $data) {
                $data->deployed_at  = null;
                $data->updated_at   = $now;
                $insertData         = $data->toArray();
                $insertData['data'] = json_encode($insertData['data']);

                unset($insertData['shop_items']);

                $destinationDatabase->table($this->getTable())->updateOrInsert(['id' => $data->id], $insertData);

                $destinationDatabase->table('shop_items')->where('shop_id', $data->id)->delete();
                foreach ($data->shopItems as $shopItem) {
                    $rowData         = $shopItem->toArray();
                    $rowData['data'] = json_encode($rowData['data']);

                    $destinationDatabase->table('shop_items')->insert($rowData);
                }
            }

            /**
             * Turn off auto updated_at
             */
            $this->timestamps = false;
            $builder->update(['deployed_at' => $now]);

            DB::connection("$toEnv.cms")->commit();
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::connection("$toEnv.cms")->rollback();
            CmsActionLogService::logAction('deploy_configs', 'fail', ['message' => $exception->getMessage()]);
            $status = false;
        }

        return $status;
    }
}
