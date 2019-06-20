<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * CmsModel
 */
abstract class CmsModel extends Model
{

    /**
     * Look in config/database.php
     */
    const DB_CONNECTION = 'cms';

    /**
     * CmsModel constructor.
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
