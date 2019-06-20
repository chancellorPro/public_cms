<?php

namespace App\Models\Cms;

use App\Models\CmsModel;

/**
 * NlaSection
 */
class NlaSection extends CmsModel
{
    const DB_CONNECTION = 'group_admin';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sort',
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
