<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * AssetLocalization
 *
 * @property int $asset_id
 * @property string $lang
 * @property string $name
 * @property Asset $asset
 */
class AssetLocalization extends Model
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Asset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
