<?php

namespace App\Models\Cms;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupAdmin
 */
class GroupAdmin extends Model
{

    const DB_CONNECTION = 'group_admin';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'is_main',
        'sender_id',
        'receiver_id',
        'updated_at',
        'created_at',
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
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    /**
     * Cms User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cmsUser()
    {
        return $this->hasOne(CmsUser::class, 'id', 'sender_id');
    }
}
