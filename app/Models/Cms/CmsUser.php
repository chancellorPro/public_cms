<?php

namespace App\Models\Cms;

use App\Models\User\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * CmsUser
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $blocked_at
 * @property string $visited_at
 * @property string $created_at
 * @property CmsActionsHistory[] $cmsActionsHistories
 * @property SystemMessage[] $systemMessages
 * @property Asset[] $createdAssets
 * @property Asset[] $updatedAssets
 */
class CmsUser extends Authenticatable
{

    use Notifiable;

    const ADMIN = 1;
    const TROPHY_CUP_MANAGER_WEB = 7;
    const FB_WEB_GROUPS_MANAGER = 8;
    const GROUP_EVENT_MANAGER = 9;
    const TROPHY_ASSET_MANAGER_WEB = 10;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'password',
        'name',
        'email',
        'user_id',
        'fb_group_id',
        'created_by',
        'tiara',
        'trophy',
        'is_super_admin',
        'blocked_at',
        'visited_at',
        'created_at',
        'api_token',
    ];

    const DB_CONNECTION = 'group_admin';

    /**
     * CmsUser constructor.
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Is super admin
     *
     * @return mixed
     */
    public function isSuperAdmin()
    {
        return $this->is_super_admin;
    }

    /**
     * Trophy Cup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trophyCupConfig()
    {
        return $this->hasOne(TrophyCupConfig::class, 'user_id', 'id');
    }

    /**
     * Responsive admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function responsiveAdmin()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Certs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certConfig()
    {
        return $this->hasOne(CertificateConfig::class, 'user_id', 'id');
    }

    /**
     * CmsActionsHistory relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cmsActionsHistories()
    {
        return $this->hasMany(CmsActionsHistory::class);
    }

    /**
     * SystemMessage relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function systemMessages()
    {
        return $this->hasMany(SystemMessage::class);
    }

    /**
     * Asset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdAssets()
    {
        return $this->hasMany(Asset::class, 'created_by');
    }

    /**
     * Asset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updatedAssets()
    {
        return $this->hasMany(Asset::class, 'updated_by');
    }

    /**
     * CmsRole relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cmsRoles()
    {
        return $this->belongsToMany(CmsRole::class, 'cms_user_role');
    }

    /**
     * CmsUserBookmark relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cmsUserBookmarks()
    {
        return $this->hasOne(CmsUserBookmark::class);
    }

    /**
     * Bookmarks
     *
     * @return array|mixed
     */
    public function bookmarks()
    {
        // phpcs:disable
        // TODO: Cache does not work. Fix it
        // $redisKey = 'cms_user:' . $this->id . ':bookmarks';
        // $bookmarks = Redis::get($redisKey);
        //
        // if (empty($bookmarks)) {
        // $bookmarks = $this->cmsUserBookmarks()->firstOrNew([], ['bookmarks'=>'{}'])->bookmarks;
        // Redis::set($redisKey, $bookmarks);
        // }
        //
        // return json_decode($bookmarks, true);
        // phpcs:enable

        $bookmarks = [];
        if (Cache::has('cms_user_' . $this->id . '_bookmarks')) {
            $bookmarks = json_decode(Cache::get('cms_user_' . $this->id . '_bookmarks'), true);
        } else {
            $bookmarksData = $this->cmsUserBookmarks()->first();
            if ($bookmarksData) {
                $bookmarks = json_decode($bookmarksData->bookmarks, true);
                Cache::put('cms_user_' . $this->id . '_bookmarks', $bookmarksData->bookmarks, 60 * 24);
            }
        }
        return $bookmarks;
    }

    /**
     * Set password attribute
     *
     * @param string $value Hash of the password
     *
     * @return string
     */
    public function setPasswordAttribute(?string $value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }

        return $this->attributes['password'];
    }

    /**
     * Check user permissions
     *
     * @param string $permission Permission
     *
     * @return boolean
     */
    public function hasPermission(string $permission)
    {
        if (empty($permission)) {
            return false;
        }

        $permissions = $this->getPermissions();

        return $permissions->contains($permission);
    }

    /**
     * Get all user permissions
     *
     * @return Collection
     */
    public function getPermissions()
    {
        $this->load('cmsRoles.cmsRolePermissions');

        $permissions = [];
        foreach ($this->cmsRoles as $cmsRole) {
            foreach ($cmsRole->cmsRolePermissions as $cmsRolePermission) {
                $permissions[] = $cmsRolePermission->permission;
            }
        }
        return collect($permissions);
    }

    /**
     * Sync users in all env
     *
     * @return void
     */
    public static function sync()
    {
        $stageDatabase = DB::connection('stage.cms');
        $liveDatabase = DB::connection('live.cms');
        $sourceDatabase = DB::connection('dev.cms');

        foreach ($sourceDatabase->table('cms_users')->get() as $data) {
            $stageDatabase->table('cms_users')->updateOrInsert(['id' => $data->id], (array)$data);
            $liveDatabase->table('cms_users')->updateOrInsert(['id' => $data->id], (array)$data);
        }
    }
}
