<?php

namespace App\Services\Admin;

use App\Models\Mountain;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\UploadedFile;

class MountainService
{
    use HandlesImageUpload;

    /**
     * Menyimpan data gunung baru ke database
     */
    public function createMountain(array $data, ?UploadedFile $imageFile, int $adminId): Mountain
    {
        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile, 'mountains', $data['name']);
        }

        $data['created_by'] = $adminId;

        return Mountain::create($data);
    }

    /**
     * Memperbarui data gunung yang sudah ada
     */
    public function updateMountain(Mountain $mountain, array $data, ?UploadedFile $imageFile): Mountain
    {
        if ($imageFile) {
            // Hapus gambar lama jika ada melalui trait
            $this->deleteImage($mountain->image);
            // Simpan gambar baru
            $data['image'] = $this->uploadImage($imageFile, 'mountains', $data['name']);
        }

        $mountain->update($data);

        return $mountain;
    }

    /**
     * Menghapus gunung dari database dan membersihkan gambar dari storage
     */
    public function deleteMountain(Mountain $mountain): bool
    {
        $this->deleteImage($mountain->image);
        return $mountain->delete();
    }
}
