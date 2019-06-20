<?php

namespace App\Models\User;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User
 */
class User extends UserModel
{
    use SoftDeletes;

    const ROLE_USER  = 1;
    const ROLE_NPC   = 2;
    const ROLE_MAGIC = 3;

    const ROLE_ALIASES = [
        self::ROLE_USER  => 'User',
        self::ROLE_NPC   => 'NPC',
        self::ROLE_MAGIC => 'Magic',
    ];

    const ACCOUNT_TYPES = [
        0 => 'New',
        1 => 'Main',
        2 => 'Alt',
        3 => 'Mult',
    ];

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Dates
     *
     * @var array
     */
    protected $dates = [
        'next_fcd',
        'payed_at',
        'blocked_at',
        'visited_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'fb_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'country',
        'xp',
        'cash',
        'coins',
        'role',
        'payed_at',
        'blocked_at',
        'visited_at',
        'created_at',
        'assets_counter',
    ];

    /**
     * UserAsset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAssets()
    {
        return $this->hasMany(UserAsset::class);
    }

    /**
     * UserError relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userErrors()
    {
        return $this->hasMany(UserError::class);
    }

    /**
     * Generate asset's instance ID
     *
     * @return integer
     */
    public function generateAssetInstanceId():int
    {
        return $this->increment('last_instance_id');
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Reset FCD
     *
     * @param integer $id User ID
     *
     * @return mixed
     */
    public static function resetFcd(int $id)
    {
        $user           = self::findOrFail($id);
        $user->next_fcd = now();

        return $user->save();
    }

    /**
     * Get account types (for select)
     *
     * @return array
     */
    public static function getAccountTypes()
    {
        $types = [];
        foreach (self::ACCOUNT_TYPES as $typeId => $typeName) {
            $types[] = ['id' => $typeId, 'name' => $typeName];
        }
        return $types;
    }

    /**
     * UserPet relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPets()
    {
        return $this->hasMany(UserPet::class);
    }


}
