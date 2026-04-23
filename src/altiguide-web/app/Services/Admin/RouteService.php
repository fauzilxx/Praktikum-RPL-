<?php

namespace App\Services\Admin;

use App\Models\Mountain;
use App\Models\Route;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\UploadedFile;

class RouteService
{
    use HandlesImageUpload;

    /**
     * Membuat data rute baru di database dan menghubungkannya dengan gunung
     */
    public function createRoute(array $data, Mountain $mountain, int $adminId, ?UploadedFile $imageFile): Route
    {
        $data['mountain_id'] = $mountain->id;

        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile, 'routes', $data['name']);
        }
        
        return Route::create($data);
    }

    /**
     * Memperbarui rute spesifik yang sudah ada
     */
    public function updateRoute(Route $route, array $data, ?UploadedFile $imageFile): Route
    {
        if ($imageFile) {
            $this->deleteImage($route->image);
            $data['image'] = $this->uploadImage($imageFile, 'routes', $data['name']);
        }

        $route->update($data);
        return $route;
    }

    /**
     * Menghapus rute dan gambarnya
     */
    public function deleteRoute(Route $route): bool
    {
        $this->deleteImage($route->image);
        return $route->delete();
    }
}
