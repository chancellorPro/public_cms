<?php

namespace App\Traits\Deploy;

use Storage;

/**
 * Trait for the model
 */
trait DeployFileModel
{

    /**
     * Deploy file
     *
     * @param string $fileName File name
     * @param string $fromEnv  From env
     * @param string $toEnv    To env
     *
     * @return void
     */
    protected function deployFile(?string $fileName, string $fromEnv, string $toEnv)
    {
        if ($fileName) {
            $file            = static::getUploadFolder($fromEnv)
                . '/' . getSubFolder($fileName) . '/' . $fileName;
            $destinationFile = static::getUploadFolder($toEnv)
                . '/' . getSubFolder($fileName) . '/' . $fileName;

            if (Storage::exists($file) && !Storage::exists($destinationFile)) {
                Storage::copy($file, $destinationFile);
            }
        }
    }
}
