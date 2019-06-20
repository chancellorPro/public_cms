<?php

namespace App\Models\Cms;

use App\Models\CmsModel;
use Illuminate\Support\Facades\Auth;

/**
 * Class ActionType
 */
class ClientApi extends CmsModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_apis';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'api_config_id',
        'platform',
        'client_version',
        'force_update',
        'created_by',
        'updated_by',
    ];

    /**
     * Boot
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_by = Auth::user()->id;
        });

        // create a event to happen on saving
        static::saving(function ($table) {
            $table->created_by = Auth::user()->id;
            $table->updated_by = Auth::user()->id;
        });
    }

    /**
     * CmsUser relation. Created By
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(CmsUser::class, 'created_by');
    }

    /**
     * CmsUser relation. Updated By
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(CmsUser::class, 'updated_by');
    }
}
