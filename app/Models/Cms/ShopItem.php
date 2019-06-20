<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * ShopItem
 *
 * @property int $id
 * @property int $shop_id
 * @property int $asset_id
 * @property mixed $data
 * @property string $created_at
 * @property Shop $shop
 * @property Asset $asset
 */
class ShopItem extends Model
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'asset_id',
        'data',
        'sellable',
        'created_at',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'data'     => 'json',
        'sellable' => 'boolean',
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
     * Save shop items
     *
     * @param integer $shopId Shop ID
     * @param array   $items  Items for insert
     *
     * @return void
     */
    public static function saveItems(int $shopId, array $items)
    {
        self::where('shop_id', $shopId)->delete();

        /**
         * Mark shop as updated
         */
        $shop = Shop::find($shopId);
        $shop->touch();

        array_walk($items, function (&$item) use ($shopId) {
            $item['shop_id']  = $shopId;
            $item['data']     = !empty($item['data']) ? json_encode($item['data']) : null;
            $item['sellable'] = !empty($item['sellable']);
        });

        self::insert($items);
    }
}
