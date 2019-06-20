<?php

namespace App\Models\Cms;

use App\Models\DeployModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActionTypeAttribute
 */
class ActionTypeAttribute extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 2;

    /**
     * Relationship with few conditions
     */
    use \Awobaz\Compoships\Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_type_attributes';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'default_value',
        'possible_values',
        'type',
        'alias',
        'action_type_group_id',
        'editable_on_stage',
        'editable_on_dev',
        'deployable_to_stage',
        'deployable_to_dev',
    ];

    /**
     * ActionTypeGroup relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasOne
     */
    public function actionTypeGroup()
    {
        return $this->hasOne(ActionTypeGroup::class, 'id', 'action_type_group_id');
    }
}
