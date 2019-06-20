<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserModel
 */
abstract class UserModel extends Model
{

    /**
     * Look in config/database.php
     */
    const DB_CONNECTION = 'user';

    /**
     * UserModel constructor.
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
