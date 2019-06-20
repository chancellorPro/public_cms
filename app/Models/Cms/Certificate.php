<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Certificate
 */
class Certificate extends Model
{

    /**
     * Look in config/database.php
     */
    const DB_CONNECTION = 'group_admin';

    const CERT_SUBTYPE = 45;
    const IS_ACTIVE = 1;

    protected $table = 'cert_assets_visibility';

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'status',
    ];

    /**
     * Get asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assetId()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    /**
     * TrophyCupConfig constructor.
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
}
