<?php

namespace App\Models\Cms;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class CmsRolePermission
 */
class CmsRolePermission extends Model
{

    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_role_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission'
    ];

    const DB_CONNECTION = 'group_admin';

    /**
     * CmsRolePermission constructor.
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
     * CmsRole relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cmsRole()
    {
        return $this->belongsToMany(CmsRole::class);
    }
}
