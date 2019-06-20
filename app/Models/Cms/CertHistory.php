<?php

namespace App\Models\Cms;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TrophyHistory
 */
class CertHistory extends Model
{

    protected $table = 'cert_history';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'sender_id',
        'receiver_id',
        'asset_id',
        'cms_user',
        'created_at',
        'updated_at',
    ];

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
