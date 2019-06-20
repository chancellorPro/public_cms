<?php

namespace App\Models\User;

use App\Models\Cms\Placement;
use App\Models\UserModel;

/**
 * UserPet
 *
 * @property int $id
 * @property int $user_id
 * @property integer $type
 * @property string $name
 * @property integer $gender
 * @property mixed $data
 * @property string $created_at
 * @property User $user
 * @property Placement $placement
 */
class UserPet extends UserModel
{

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Incrementing
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Primary key
     *
     * @var array
     */
    public $primaryKey = [
        'user_id',
        'placement_id',
    ];

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'placement_id',
        'name',
        'gender',
        'scale',
        'color',
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
