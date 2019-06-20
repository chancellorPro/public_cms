<?php

namespace App\Models\Cms;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupEvent
 */
class GroupEvent extends Model
{

    const DB_CONNECTION = 'group_admin';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date_from',
        'date_to',
        'assets_setup',
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
}
