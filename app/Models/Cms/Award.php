<?php

namespace App\Models\Cms;

use App\Models\DeployModel;

/**
 * Award
 *
 * @property int $id
 * @property int $asset_id
 * @property int $coins
 * @property int $cash
 * @property int $xp
 * @property string $created_at
 * @property Asset $asset
 */
class Award extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 4;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'coins',
        'cash',
        'xp',
    ];

    /**
     * Has assets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'award_assets');
    }

}
