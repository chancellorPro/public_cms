<?php

namespace App\Traits\PreviewUpload;

use Storage;

/**
 * Trait for the model
 */
trait UpdatePreviewImage
{

    /**
     * Get upload folder
     *
     * @return string
     */
    abstract protected static function getUploadFolder():string;

    /**
     * Update preview image of a product
     *
     * @param null|string $newFileName Name of the new file
     * @param null|string $oldFileName Name of the old file
     *
     * @return void
     */
    protected static function updatePreviewImage(?string $newFileName, ?string $oldFileName = '')
    {
        if (!empty($newFileName)) {
            $tmpFile = 'tmp/' . self::getUploadFolder() . '/' . $newFileName;
            $newFile = self::getUploadFolder() . '/' . getSubFolder($newFileName) . '/' . $newFileName;
            if (Storage::exists($tmpFile)) {
                Storage::move($tmpFile, $newFile);
            }
        }

        /**
         * If an old file exists
         */
        if (!empty($oldFileName)) {
            $oldFile = self::getUploadFolder() . '/' . getSubFolder($oldFileName) . '/' . $oldFileName;
            if (Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }
        }
    }
}
