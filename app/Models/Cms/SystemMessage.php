<?php

namespace App\Models\Cms;

use App\Models\User\UserSystemMessage;
use Illuminate\Database\Eloquent\Model;

/**
 * SystemMessage
 *
 * @property int $id
 * @property int $cms_user_id
 * @property string $message
 * @property string $created_at
 * @property CmsUser $cmsUser
 * @property UserSystemMessage[] $userSystemMessages
 */
class SystemMessage extends Model
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'cms_user_id',
        'message',
        'created_at',
    ];

    /**
     * CmsUser relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cmsUser()
    {
        return $this->belongsTo(CmsUser::class);
    }

    /**
     * UserSystemMessage relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSystemMessages()
    {
        return $this->hasMany(UserSystemMessage::class);
    }
}
