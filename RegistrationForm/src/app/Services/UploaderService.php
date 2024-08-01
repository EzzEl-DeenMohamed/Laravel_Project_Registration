<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploaderService
{
    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('public');
    }


    public function uploadBinaryFile(UploadedFile $file, string $basePath): string
    {
        $fileName = self::generateFileName($file->getClientOriginalName());
        $filePath = self::generateFilePath($basePath, $fileName);
        $this->disk->put($filePath, file_get_contents($file));

        return $filePath;
    }

    private static function generateFilePath(string $basePath, string $fileName): string
    {
        $now = Carbon::now();

        return $basePath . '/' . $now->format('Y') . '/' . $now->format('m') . '/' . $now->format('d') . '/' . $fileName;
    }

    private static function generateFileName(string $fileName): string
    {
        return (\auth()->user() ? auth()->user()->id : null) . '_' . time() . '_' . $fileName;
    }
}
