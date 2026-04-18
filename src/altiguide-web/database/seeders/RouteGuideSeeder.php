<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Mountain;
use App\Models\Route;

class RouteGuideSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or Find Mountain
        $merbabu = Mountain::firstOrCreate(
            ['name' => 'Gunung Merbabu'],
            [
                'location' => 'Kabupaten Magelang, Boyolali, Semarang',
                'altitude' => 3142,
                'description' => 'Gunung Merbabu adalah gunung api tipe Strato yang terletak secara geografis pada 7°5’ LS dan 110°24’ BT. Dikenal dengan keindahan sabananya.',
                'latitude' => -7.453333,
                'longitude' => 110.439444,
            ]
        );

        // 2. Create Route: Suwanting
        $suwanting = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Suwanting'],
            [
                'distance' => 6.45,
                'estimated_time' => 600, // 10 jam dalam menit
                'difficulty' => 'hard',
                'is_active' => true,
            ]
        );

        // 3. Create Route Info for Suwanting
        $suwanting->routeInfo()->updateOrCreate(
            ['route_id' => $suwanting->id],
            [
                'basecamp_address' => 'Dusun Suwanting, Desa Banyuroto, Kec. Sawangan, Kab. Magelang, Jawa Tengah.',
                'basecamp_altitude' => 1500,
                'simaksi_price' => 65000,
                'facilities_description' => "Basecamp Suwanting menyediakan fasilitas yang memadai untuk tempat istirahat pendaki sebelum memulai perjalanan. Tersedia pos pendaftaran resmi (Simaksi), area parkir kendaraan, dan toilet umum/kamar mandi. \nDi area sekitar basecamp juga terdapat warung-warung warga yang menyediakan makanan hangat, air mineral, serta perlengkapan logistik darurat. Selain itu, terdapat jasa porter dan penyewaan alat jika pendaki membutuhkan bantuan tambahan.",
                'logistics_description' => "Jalur pendakian Merbabu via Suwanting selain berat dan penuh tantangan, namun jalur pendakian ini memiliki daya tarik yang luar biasa. Terdapat dua buah gentong air di jalur ini (Pos Air) sebagai sumber air. Namun pendaki wajib mempersiapkan air yang cukup dari bawah."
            ]
        );

        // 4. Create Waypoints (Pos 1 - Puncak) for Suwanting
        $waypoints = [
            [
                'name' => 'Pos 1 Lembah Lempong',
                'altitude' => 1555,
                'distance_from_prev' => 0.2, // km 
                'estimated_time_minutes' => 5, 
                'description' => 'Berupa tanah datar yang tidak terlalu luas dan tidak ada selter untuk berteduh. Vegetasi masih didominasi hutan pinus, semak dan rumput.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Bendera',
                'altitude' => 2186,
                'distance_from_prev' => 2.0, 
                'estimated_time_minutes' => 150, // 2-2.5 jam 
                'description' => 'Melewati lembah Gosong, Cemoro, Ngrijan, dan Mitoh. Trek tanah cukup liat dan licin saat hujan. Pos 2 berupa tanah datar berundak dan pemandangan agak terbuka, bisa untuk mendirikan tenda.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos Air',
                'altitude' => 2665,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 180, // 2.5 - 3 jam
                'description' => 'Jalur paling terjal. Vegetasi dominan semak dan pohon mlanding. Terdapat dua buah gentong berisi air yang dialirkan melalui pipa, ini menjadi satu-satunya sumber air.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Dampo Awang',
                'altitude' => 2740,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 20, 
                'description' => 'Sangat luas dan mampu menampung puluhan tenda. Tempat terbaik untuk mendirikan tenda. Vegetasi hanya rerumputan serta edelweis, awas angin kencang.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sabana 1 - Puncak Suwanting',
                'altitude' => 3105,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 90, 
                'description' => 'Kawasan Sabana 1, 2, dan 3. Trek konstan menanjak. Vegetasi rumput terbuka dengan potensi angin badai.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Triangulasi',
                'altitude' => 3142,
                'distance_from_prev' => 0.25, 
                'estimated_time_minutes' => 15, 
                'description' => 'Kawasan puncak Triangulasi tidak terlalu luas dan ditandai dengan tugu taman nasional.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Kenteng Songo',
                'altitude' => 3142,
                'distance_from_prev' => 0.15, 
                'estimated_time_minutes' => 5, 
                'description' => 'Titik pertemuan jalur Suwanting dengan Selo. Terdapat situs cagar budaya lumpang batu alami.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypoints as $index => $wp) {
            $suwanting->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }
    }
}
