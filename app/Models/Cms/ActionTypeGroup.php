<?php

namespace App\Models\Cms;

use App\Models\DeployModel;

/**
 * Class ActionTypeGroup
 */
class ActionTypeGroup extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 1;
    /**
     * Relationship with few conditions
     */
    use \Awobaz\Compoships\Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_type_groups';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    /**
     * ActionTypeAttribute relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasMany
     */
    public function actionTypeAttribute()
    {
        return $this->hasMany(ActionTypeAttribute::class, 'action_type_group_id', 'id');
    }
}
