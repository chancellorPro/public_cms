<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TrophyCupConfig
 */
class TrophyCupConfig extends Model
{

    protected $table = 'trophy_cup_config';

    const DB_CONNECTION = 'group_admin';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The "type" of the key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'asset_id',
        'limit',
        'updated_at',
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
