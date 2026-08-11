<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

trait CompressesImages
{
    /**
     * Kompres & simpan gambar upload ke storage/app/public/{folder}.
     * Otomatis resize kalau lebih besar dari maxWidth, dan konversi ke WebP
     * untuk ukuran file jauh lebih kecil tanpa penurunan kualitas signifikan.
     */
    protected function storeCompressedImage(UploadedFile $file, string $folder, int $maxWidth = 1280, int $quality = 75): string
    {
        $image = Image::read($file);

        // Resize hanya kalau gambar lebih lebar dari batas maksimal (tidak upscale gambar kecil)
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $filename = $folder . '/' . Str::random(20) . '.webp';
        $fullPath = storage_path('app/public/' . $filename);

        // Pastikan folder tujuan ada
        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $image->toWebp($quality)->save($fullPath);

        return $filename;
    }
}
