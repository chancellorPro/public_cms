<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * StatsModel
 */
abstract class StatsModel extends Model
{

    /**
     * Look in config/database.php
     */
    const DB_CONNECTION = 'stats';

    /**
     * StatsModel constructor.
     *
     * @param array $attributes Attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = environment() . '.' . self::DB_CONNECTION;
    }
}
