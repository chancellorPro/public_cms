<?php

namespace App\Models\User;

use App\Models\UserModel;

/**
 * UserError
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $type
 * @property string $request_data
 * @property string $response_data
 * @property string $message
 * @property string $created_at
 * @property User $user
 */
class UserError extends UserModel
{

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
        'type',
        'request_data',
        'response_data',
        'message',
        'created_at',
    ];

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
