<?php

namespace App\Models\Cms;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventLog
 */
class EventLog extends Model
{

    /**
     * Look in config/database.php
     */
    const DB_CONNECTION = 'group_admin';

    protected $table = 'event_log';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'event_id',
        'asset_id',
        'sender_id',
        'receiver_id',
        'cms_user_id',
        'news_message',
        'gc',
        'created_at',
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

    /**
     * Sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    /**
     * Receiver
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }
}
