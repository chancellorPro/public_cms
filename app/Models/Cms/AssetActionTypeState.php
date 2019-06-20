<?php

namespace App\Models\Cms;

use App\Models\DeployModel;
use App\Services\CmsActionLogService;
use \DB;
use Carbon\Carbon;

/**
 * Class AssetActionTypeState
 */
class AssetActionTypeState extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 6;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_action_type_states';

    /**
     * Incrementing
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Primary key
     *
     * @var array
     */
    protected $primaryKey = [
        'asset_id',
        'action_type_state_id',
    ];

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'action_type_state_id',
        'award_id',
    ];

    /**
     * ActionTypeState relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function actionTypeState()
    {
        return $this->hasOne(ActionTypeState::class, 'id', 'action_type_state_id');
    }

    /**
     * Get award
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function award()
    {
        return $this->hasOne(Award::class, 'id', 'award_id');
    }

    /**
     * Insert or update
     *
     * @param array $data Data
     *
     * @return void
     */
    public static function insertUpdate(array $data)
    {
        $sql = "INSERT INTO asset_action_type_states (
            `asset_id`,
            `action_type_state_id`,
            `award_id`,
            `created_at`,
            `updated_at`
        ) VALUES (?,?,?,?,?) 
        ON DUPLICATE KEY UPDATE 
            `award_id` = VALUES(`award_id`),
            `updated_at` = VALUES(`updated_at`)";

        DB::insert($sql, [
            $data['asset_id'],
            $data['action_type_state_id'],
            $data['award_id'],
            Carbon::now(),
            Carbon::now(),
        ]);
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

        $builder = $this->where(function ($query) {
            $query->whereRaw('deployed_at < updated_at')
                ->orWhereNull('deployed_at');
        });

        try {
            foreach ($builder->get() as $data) {
                $data->deployed_at = null;
                $data->updated_at  = $now;

                $insertData = $data->toArray();

                $query = [
                    'asset_id'             => $data->asset_id,
                    'action_type_state_id' => $data->action_type_state_id,
                ];
                $destinationDatabase->table($this->getTable())->updateOrInsert($query, $insertData);
            }
            /**
             * Turn off auto updated_at
             */
            $this->timestamps = false;
            $builder->update(['deployed_at' => $now]);
        } catch (\Illuminate\Database\QueryException $exception) {
            CmsActionLogService::logAction('deploy_configs', 'fail', ['message' => $exception->getMessage()]);
            $status = false;
        }
        return $status;
    }
}
