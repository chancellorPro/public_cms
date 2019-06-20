<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * CmsShopRelease
 *
 * @property int $id
 * @property int $shop_id
 * @property string $name
 * @property string $comment
 * @property string $created_at
 * @property string $started_at
 * @property Shop $shop
 */
class CmsShopRelease extends Model
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'name',
        'comment',
        'created_at',
        'started_at',
    ];

    /**
     * Shop relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
