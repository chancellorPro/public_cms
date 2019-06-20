<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * AppConfig
 *
 * @property string $key
 * @property mixed $value
 */
class AppConfig extends Model
{

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Disable Eloquent timestamps
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'updated_at',
    ];

    
    /**
     * Create or update app config
     *
     * @param string $name   Name
     * @param mixed  $config Config
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setConfig(string $name, $config)
    {
        return $this->updateOrCreate(
            [
                'key' => $name,
            ],
            [
                'value'      => json_encode($config),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
