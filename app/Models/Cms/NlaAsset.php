<?php

namespace App\Models\Cms;

use App\Models\CmsModel;

/**
 * NlaAssets
 */
class NlaAsset extends CmsModel
{
    const DB_CONNECTION = 'group_admin';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'category_id',
    ];

    /**
     * GroupAdmin constructor.
     *
     * @param array $attributes Attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = environment() . '.' . self::DB_CONNECTION;
    }

    /**
     * Has assets
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assets()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
