<?php

namespace App\Models\User;

use App\Models\UserModel;

/**
 * UserNews
 */
class UserNews extends UserModel
{

    const DIRECTION_TO_ME = 0;
    const DIRECTION_FROM_ME = 1;

    const NEWS_TYPE_GIFT_TYPE = 3;
    const ATTACHMENT_TYPE_GIFT_ASSET = 2;

    const STATUS_NEW= 0;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_news';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'interlocutor_id',
        'direction',
        'type',
        'status',
        'message',
        'created_at',
        'attachements',
    ];

}
