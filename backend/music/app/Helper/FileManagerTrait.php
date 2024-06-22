<?php
namespace App\Helper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileManagerTrait
{
    /**
     * @param object $file
     * @param string $path
     * @return array|void
     */
    public function uploads(object $file, int $id, string $model)
    {
        if ($file) {
            $fileName = time() . $file->getClientOriginalName();
            $path = 'public/' .$model . '/' . $id;
            $absolutePath = storage_path('app/' . $path);

            if(File::exists($absolutePath)) {
                File::deleteDirectory($absolutePath);
            }

            $file->storeAs($path, $fileName);

            $originFileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $filePath = asset('http://localhost:8000/storage/' . $model . '/' . $id . '/' . $fileName);

            return [
                'image' => $filePath,
            ];
        }
    }

    public function uploadMp3s(object $file, int $id)
    {
        if ($file) {
            $fileName = time() . $file->getClientOriginalName();

            $path = 'public/mp3s/' . $id;
            $absolutePath = storage_path('app/' . $path);
            if(File::exists($absolutePath)) {
                File::deleteDirectory($absolutePath);
            }
            $file->storeAs($path, $fileName);

            $originFileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $filePath = asset('http://localhost:8000/storage/mp3s/' . $id . '/' . $fileName);
            return [
                'path' => $filePath,
            ];
        }
    }

    /**
     * @param object $file
     * @param int $precision
     * @return mixed|string
     */
    public function fileSize(object $file, int $precision = 2): mixed
    {
        $size = $file->getSize();

        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}
