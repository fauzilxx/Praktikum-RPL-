<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
    /**
     * Menyimpan gambar ke disk public
     *
     * @param UploadedFile $file File gambar yang diupload
     * @param string $folderName Nama folder (contoh: 'mountains', 'routes')
     * @param string $prefixName Prefix nama file (opsional)
     * @return string Path relatif gambar yang disimpan
     */
    protected function uploadImage(UploadedFile $file, string $folderName, string $prefixName = 'img'): string
    {
        $filename = Str::slug($prefixName) . '-' . time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folderName, $filename, 'public');
    }

    /**
     * Menghapus gambar dari disk public
     *
     * @param string|null $path Path gambar yang akan dihapus
     * @return void
     */
    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}