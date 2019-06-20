<?php

namespace App\Models\User;

use App\Models\Cms\Asset;
use App\Models\Cms\Placement;
use App\Models\UserModel;

/**
 * UserAsset
 *
 * @property int $user_id
 * @property int $instance_id
 * @property int $asset_id
 * @property int $room_id
 * @property int $sort
 * @property mixed $data
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Asset $asset
 */
class UserAsset extends UserModel
{

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'asset_id',
        'placement_id',
        'instance_id',
        'sort',
        'data',
        'transform_data',
    ];

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Asset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    
    /**
     * Placement relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function placement()
    {
        return $this->belongsTo(Placement::class);
    }
}
