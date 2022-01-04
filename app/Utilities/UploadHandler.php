<?php

namespace App\Utilities;


use App\Exceptions\FileUploadException;
use App\Models\Auth\Library;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class UploadHandler
{
 public $path;
    const ROOT_FOLDER = 'public/uploads';

    const FOLDER = [
        'jpeg' => 'images',
        'png' => 'images',
        'jpg' => 'images',
        'pdf' => 'doc',
        'doc' => 'doc',
        'mp4' => 'video',
        'avi' => 'video',
    ];

    const THUMBNAIL_SIZE = [

        '50X50' => [50, 50],
        '200X200' => [200, 200],
        '350X350' => [350, 350],
    ];


    public static function validate($file)
    {
        if (!$file)
            return null;
        $validateArray = [
            'file' => 'mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:20480'
        ];

        $validator = Validator::make(['file' => $file], $validateArray);

        if ($validator->fails()) {
            throw new FileUploadException(json_encode($validator->errors()->getMessages()));
        }
    }

    public static function save(UploadedFile $file = null, $path = null)
    {
        if (!$file)
            return null;

        $fileName = $path ? basename($path) : $file->getClientOriginalName();
        $ext = $file->extension();
        $size = $file->getSize();
        $year = Jdf::jdate('Y');
        $month = Jdf::jdate('m');
        $folder = in_array($ext, array_keys(self::FOLDER)) ? self::FOLDER[$ext] : 'etc';


        if ($path) {

            $path = self::ROOT_FOLDER . '/' . str_replace($fileName, '', $path);
            Storage::delete("$path/$fileName");
        } else {
            $path = self::ROOT_FOLDER . "/{$folder}/{$year}/{$month}";
        }


        if (Storage::exists("$path/$fileName")) {
            $error = ['1' => [' فایلی با این نام از قبل در کتابخانه در این ماه  وجود دارد']];
            throw new FileUploadException(json_encode($error));
        } else {

            if ($file->storeAs($path, $fileName)) {
                $path = trim($path, '/');
                self::createThumbnail("$path/$fileName");
                $path = str_replace(self::ROOT_FOLDER . '/', '', $path);
                $path = str_replace($fileName, '', $path);
//            dd($path);
                return [
                    'name' => basename($fileName, ".{$ext}"),
                    'ext' => $ext,
                    'folder' => $folder,
                    'path' => trim($path, '/'),
                    'size' => $size,
                ];
            }
            return null;
        }
    }
    public static function createThumbnail($path)
    {
        $filename = basename($path);
        $pathWithoutFilename = trim(str_replace(basename($path), '', $path), '/');
//        dd($pathWithoutFilename);
        $readPath = "app/{$pathWithoutFilename}";

        foreach (self::THUMBNAIL_SIZE as $key => $size) {
            $storePath = "app/{$pathWithoutFilename}/{$key}";
            $thumbDir = "{$pathWithoutFilename}/{$key}";
            $img = Image::make(storage_path("{$readPath}/$filename"));
            $img->resize($size[0], $size[1]);
            if (!Storage::exists($thumbDir)) {
                Storage::makeDirectory($thumbDir);
            }
            $img->save(storage_path("{$storePath}/{$filename}"));
        }
    }


}
