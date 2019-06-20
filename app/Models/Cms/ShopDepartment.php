<?php

namespace App\Models\Cms;

use App\Models\DeployModel;
use App\Services\CmsActionLogService;
use App\Traits\PreviewUpload\PreviewUploadModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Shop Department
 */
class ShopDepartment extends DeployModel
{

    use PreviewUploadModel;

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 7;

    /**
     * Folder for images
     */
    const FILES_FOLDER = 'shop_department';

    /**
     * Preview field names
     *
     * @var array
     */
    protected static $previewFields = [
        'preview_url',
        'preview_url_small',
    ];


    /**
     * Get upload folder
     *
     * @param string $env Env
     *
     * @return string
     */
    protected static function getUploadFolder(?string $env = null): string
    {
        if (!$env) {
            $env = environment();
        }
        return $env . '/' . self::FILES_FOLDER;
    }

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'available',
        'preview_url',
        'preview_url_small',
    ];


    /**
     * Has shops
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shops()
    {
        return $this->belongsToMany(
            Shop::class,
            'shop_department_shops',
            'shop_department_id',
            'shop_id'
        )->withPivot([
            'name',
            'description',
            'new_items',
            'default',
            'enabled',
        ])->orderBy('position', 'asc');
    }

    /**
     * Deploy default
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     *
     * @return boolean
     */
    protected function deployDefault(string $fromEnv, string $toEnv)
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
            });

            $queryBuilder = $builder->with('shops');

            foreach ($queryBuilder->get() as $data) {
                $data->deployed_at = null;
                $data->updated_at  = $now;
                $insertData        = $data->toArray();

                unset($insertData['shops']);

                $destinationDatabase->table($this->getTable())->updateOrInsert(['id' => $data->id], $insertData);

                $this->deployFile($insertData['preview_url'], $fromEnv, $toEnv);
                $this->deployFile($insertData['preview_url_small'], $fromEnv, $toEnv);

                foreach ($data->shops as $shop) {
                    $rowData = $shop->pivot->toArray();

                    $query = [
                        'shop_department_id' => $rowData['shop_department_id'],
                        'shop_id'            => $rowData['shop_id'],
                    ];

                    $destinationDatabase->table('shop_department_shops')->updateOrInsert($query, $rowData);
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
