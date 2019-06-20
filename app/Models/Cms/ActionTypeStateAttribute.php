<?php

namespace App\Models\Cms;

use App\Models\DeployModel;
use App\Services\CmsActionLogService;
use \DB;
use Carbon\Carbon;

/**
 * Class ActionTypeStateAttribute
 */
class ActionTypeStateAttribute extends DeployModel
{
    /**
     * Relationship with few conditions
     */
    use \Awobaz\Compoships\Compoships;

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 5;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_type_state_attributes';

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
        'action_type_state_id',
        'action_type_attribute_id',
    ];

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'action_type_state_id',
        'action_type_attribute_id',
        'value',
        'overridable',
    ];

    /**
     * Insert or Update
     *
     * @param array $data Data
     *
     * @return void
     */
    public static function insertUpdate(array $data)
    {
        $sql = "INSERT INTO action_type_state_attributes (
            `action_type_state_id`,
            `action_type_attribute_id`,
            `value`,
            `overridable`,
            `created_at`,
            `updated_at`
        ) VALUES (?,?,?,?,?,?) 
        ON DUPLICATE KEY UPDATE 
            `value` = VALUES(`value`),
            `overridable` = VALUES(`overridable`),
            `updated_at` = VALUES(`updated_at`)";

        DB::insert($sql, [
            $data['action_type_state_id'],
            $data['action_type_attribute_id'],
            $data['value'] ?? '',
            isset($data['overridable']),
            Carbon::now(),
            Carbon::now(),
        ]);
    }

    /**
     * ActionTypeAttribute relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasOne
     */
    public function actionTypeAttribute()
    {
        return $this->hasOne(ActionTypeAttribute::class, 'id', 'action_type_attribute_id');
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
                    'action_type_state_id'     => $data->action_type_state_id,
                    'action_type_attribute_id' => $data->action_type_attribute_id,
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
