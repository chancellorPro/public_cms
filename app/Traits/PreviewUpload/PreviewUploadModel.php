<?php

namespace App\Traits\PreviewUpload;

use Storage;

/**
 * Trait for the model
 */
trait PreviewUploadModel
{

    use UpdatePreviewImage;
    
    /**
     * Boot
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Before create a product
         */
        static::saving(function ($model) {
            foreach (self::$previewFields as $field) {
                self::updatePreviewImage($model->{$field});
            }
        });

        /**
         * Before update a product
         */
        static::updating(function ($model) {
            foreach (self::$previewFields as $field) {
                if ($model->isDirty($field)) {
                    self::updatePreviewImage($model->{$field}, $model->getOriginal()[$field]);
                }
            }
        });
    }
}
