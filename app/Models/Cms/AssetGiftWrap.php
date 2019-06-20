<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Gift wrap
 */
class AssetGiftWrap extends Model
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'position',
        'enabled',
        'started_at',
        'finished_at',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'started_at'  => 'date',
        'finished_at' => 'date',
    ];

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'asset_id';

    /**
     * Incrementing
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Has asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }
}
