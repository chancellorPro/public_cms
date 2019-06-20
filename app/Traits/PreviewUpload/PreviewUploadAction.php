<?php

namespace App\Traits\PreviewUpload;

use App\Services\FileService;
use Illuminate\Http\Request;

/**
 * Trait for a controller
 * Adding upload action
 */
trait PreviewUploadAction
{

    /**
     * Success response
     *
     * @param array|null $data Data
     *
     * @return mixed
     */
    abstract protected function success(array $data = null);

    /**
     * Get upload folder
     *
     * @return string
     */
    abstract protected static function getUploadFolder():string;

    /**
     * Uploading an image in the tpm folder
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file     = $request->file('file');
        $fileName = uniqid() . FileService::getFileExt($file);

        $file->storeAs('tmp/' . self::getUploadFolder(), $fileName);

        return $this->success([
            'file_name' => $fileName,
        ]);
    }
}
