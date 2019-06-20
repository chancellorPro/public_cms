<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use \DB;

/**
 * Class AssetActionTypeAttribute
 */
class AssetActionTypeAttribute extends Model
{
    /**
     * Relationship with few conditions
     */
    use \Awobaz\Compoships\Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_action_type_attributes';

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
        'action_type_attribute_id',
    ];

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'action_type_state_id',
        'action_type_attribute_id',
        'value',
    ];

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
     * ActionTypeStateAttribute relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasOne
     */
    public function actionTypeStateAttribute()
    {
        return $this->hasOne(
            ActionTypeStateAttribute::class,
            [
                'action_type_state_id',
                'action_type_attribute_id',
            ],
            [
                'action_type_state_id',
                'action_type_attribute_id',
            ]
        );
    }

    /**
     * ActionTypeState relation
     *
     * @return \Awobaz\Compoships\Database\Eloquent\Relations\HasOne
     */
    public function actionTypeState()
    {
        return $this->hasOne(ActionTypeState::class, 'id', 'action_type_state_id');
    }
}
