<?php

namespace App\Models\Cms;

use App\Models\DeployModel;

/**
 * Class ActionTypeState
 */
class ActionTypeState extends DeployModel
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
    protected $table = 'action_type_states';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'action_type_id',
        'has_award',
        'index',
    ];

    /**
     * ActionTypeStateAttribute relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionTypeStateAttribute()
    {
        return $this->hasMany(ActionTypeStateAttribute::class, 'action_type_state_id', 'id');
    }
}
