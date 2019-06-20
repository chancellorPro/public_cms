<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * CmsActionsHistory
 *
 * @property int $id
 * @property int $cms_user_id
 * @property string $action
 * @property mixed $data
 * @property string $created_at
 * @property CmsUser $cmsUser
 */
class CmsActionsHistory extends Model
{
    const ACTIONS = [
        'cash_added',
        'coins_added',
        'created',
        'deleted',
        'fail',
        'updated',
    ];

    const SOURCES = [
        'app_settings',
        'asset_attributes',
        'asset_gift_wraps',
        'assets',
        'attributes',
        'awards',
        'cms_adp_categories',
        'cms_adps',
        'cms_role_permissions',
        'cms_users',
        'deploy_configs',
        'deployment',
        'placements',
        'shop_departments',
        'user_assets',
        'user_debug',
        'users',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_actions_history';

    /**
     * Disable Eloquent timestamps
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
    
    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'cms_user_id',
        'source',
        'action',
        'data',
        'created_at',
    ];

    /**
     * CmsUser relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cmsUser()
    {
        return $this->belongsTo(CmsUser::class);
    }
}
