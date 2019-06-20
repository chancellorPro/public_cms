<?php

namespace App\Models\Cms;

use App\Models\DeployModel;

/**
 * Class ActionType
 */
class ActionType extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_types';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * ActionTypeState relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionTypeState()
    {
        return $this->hasMany(ActionTypeState::class, 'action_type_id', 'id')
            ->orderBy('index');
    }
}
