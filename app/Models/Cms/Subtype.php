<?php

namespace App\Models\Cms;

use App\Models\DeployModel;

/**
 * Class Subtype
 */
class Subtype extends DeployModel
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
    protected $table = 'subtypes';

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'asset_type',
    ];

    /**
     * Get subtypes grouped by type
     *
     * @return array
     */
    public static function getSubtypeGroups():array
    {
        $subtypes = self::all();

        $subtypeGroups = [];
        foreach ($subtypes as $subtype) {
            $subtypeGroups[$subtype->asset_type][] = ['id' => $subtype->id, 'text' => $subtype->name];
        }

        return $subtypeGroups;
    }
}
