<?php

namespace App\Models\Cms;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsRole
 */
class CmsRole extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'name',
    ];

    /**
     * CmsUser relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(CmsUser::class, 'cms_user_role');
    }

    /**
     * Get selected permissions
     *
     * @return Collection
     */
    public function getPermissionsList()
    {
        $list = [];
        foreach ($this->cmsRolePermissions()->get() as $cmsRolePermission) {
            $list[] = $cmsRolePermission->permission;
        }
        return collect($list);
    }

    /**
     * CmsRolePermission relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cmsRolePermissions()
    {
        return $this->hasMany(CmsRolePermission::class);
    }

    /**
     * Delete
     *
     * @return boolean|null|void
     * @throws \Exception Can't delete
     */
    public function delete()
    {
        $cmsRolePermissions = $this->cmsRolePermissions()->get();
        
        foreach ($cmsRolePermissions as $cmsRolePermission) {
            $cmsRolePermission->delete();
        }
        parent::delete();
    }
}
