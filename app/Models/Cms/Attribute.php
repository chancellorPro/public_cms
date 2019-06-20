<?php

namespace App\Models\Cms;

use App\Configs\SubTypeConfig;
use App\Models\DeployModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 */
class Attribute extends DeployModel
{

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attributes';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'default_value',
        'possible_values',
        'type',
        'alias',
        'editable_on_stage',
        'editable_on_dev',
        'deployable_to_stage',
        'deployable_to_dev',
    ];

    /**
     * Asset relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_attributes');
    }
}
