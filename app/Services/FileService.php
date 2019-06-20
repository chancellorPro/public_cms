<?php

namespace App\Services;

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class FileService
 */
class FileService
{

    /**
     * Upload image
     *
     * @param mixed $file    File
     * @param mixed $saveDir Save dir
     * @param array $options Options
     *
     * @return mixed
     */
    public static function uploadImg($file, $saveDir, array $options = [])
    {
        $path  = $file->hashName($saveDir);
        $image = Image::make($file);

        self::resizeImage($image, $options);
        Storage::put($path, (string) $image->encode());
        return $path;
    }
    
    
    /**
     * Upload image
     *
     * @param mixed $link    Link
     * @param mixed $saveDir Save dir
     * @param array $options Options
     *
     * @return mixed
     */
    public static function uploadLinkImg($link, $saveDir, array $options = [])
    {
        $extension = pathinfo($link, PATHINFO_EXTENSION);
        $path      = $saveDir . '/' . Str::random(40) . '.' . $extension;
        $image     = Image::make($link);

        self::resizeImage($image, $options);
        Storage::put($path, (string) $image->encode());
        return $path;
    }
    
    /**
     * Resize image
     *
     * @param mixed $image   Image
     * @param array $options Options
     *
     * @return void
     */
    public static function resizeImage(&$image, array $options = [])
    {
        if (!empty($options['width']) || !empty($options['height'])) {
            $width  = empty($options['width']) ? null : $options['width'];
            $height = empty($options['height']) ? null : $options['height'];

            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (!empty($options['width']) && !empty($options['height']) && !empty($options['fill'])) {
                $background = Image::canvas($width, $height);
                $background->insert($image, 'center');
                $image = $background;
            }
        }
    }

    /**
     * Upload file
     *
     * @param mixed  $file     File
     * @param mixed  $saveDir  Save dir
     * @param string $fileName File name
     *
     * @return mixed
     */
    public static function uploadFile($file, $saveDir, string $fileName = '')
    {
        if ($fileName) {
            $path = $file->storeAs($saveDir, $fileName);
        } else {
            $path = $file->store($saveDir);
        }

        return $path;
    }

    /**
     * Get file ext
     *
     * @param mixed $file File
     *
     * @return string
     */
    public static function getFileExt($file):string
    {
        $clientOriginalName = $file->getClientOriginalName();
        return self::getFileExtByName($clientOriginalName);
    }

    /**
     * Get file's ext by name
     *
     * @param string $fileName File name
     *
     * @return string
     */
    public static function getFileExtByName(string $fileName):string
    {
        $fileNameParts = (array) explode('.', $fileName);
        $ext           = count($fileNameParts) > 1 ? '.' .$fileNameParts[count($fileNameParts) - 1] : '';
        return $ext;
    }

    /**
     * Delete
     *
     * @param mixed $path Path
     *
     * @return boolean
     */
    public static function delete($path):bool
    {
        $status = false;
        if (!empty($path) && Storage::exists($path)) {
            $status = Storage::delete($path);
        }
        return $status;
    }
}
