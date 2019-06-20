<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsUserBookmark
 */
class CmsUserBookmark extends Model
{

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cms_user_id';

    /**
     * Timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'bookmarks',
    ];
}
