<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait CompressesImages
{
    protected function storeCompressedImage(UploadedFile $file, string $folder, int $maxWidth = 1280, int $quality = 75): string
    {
        // Sementara skip kompresi karena ekstensi GD server belum mendukung JPEG decode.
        // File disimpan apa adanya tanpa resize/convert ke WebP.
        return $file->store($folder, 'public');
    }
}
