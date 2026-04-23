<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class AndongSeeder extends Seeder
{
    public function run(): void
    {
        // 1. MOUNTAIN ANDONG
        $andong = Mountain::firstOrCreate(
            ['name' => 'Gunung Andong'],
            [
                'location' => 'Kecamatan Ngablak, Kabupaten Magelang, Jawa Tengah', 
                'altitude' => 1726,
                'description' => 'Gunung Andong adalah sebuah gunung bertipe perisai di Kabupaten Magelang, Jawa Tengah. Gunung ini merupakan salah satu gunung yang ramah untuk pendaki pemula karena ketinggiannya yang bersahabat dan medannya yang tidak terlalu sulit, serta menyuguhkan pemandangan spektakuler 360 derajat.',
                'latitude' => -7.3872,  
                'longitude' => 110.3663, 
            ]
        );

        // 2. VIA PENDEM
        $pendem = Route::firstOrCreate(
            ['mountain_id' => $andong->id, 'name' => 'Gunung Andong via Pendem'],
            [
                'distance' => 2.0, 
                'estimated_time' => 100, // 15+30+35+15+5
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.3831, 
                'longitude' => 110.3705
            ]
        );

        $pendem->routeInfo()->updateOrCreate(['route_id' => $pendem->id],
            [
                'basecamp_address' => 'Dusun Pendem, Desa Girirejo, Ngablak, Magelang',
                'basecamp_altitude' => 1281,
                'simaksi_price' => 21000,
                'facilities_description' => 'Basecamp Pendem menyediakan area parkir luas, warung makan, toilet bersih, dan aula istirahat bagi pendaki. Tersedia juga tempat penyewaan alat dasar serta stopkontak untuk mengisi daya perangkat sebelum mulai mendaki.',
                'logistics_description' => 'Sangat disarankan bagi pendaki untuk membawa persediaan air penuh dari basecamp. Meskipun di awal jalur (sebelum masuk hutan) terkadang terdapat pipa air warga, namun di sepanjang jalur pendakian utama hingga puncak tidak terdapat sumber air atau mata air yang bisa diandalkan secara konsisten. Untuk logistik, jalur ini tergolong singkat (short hike), sehingga membawa camilan penambah energi dan minimal 1,5–2 liter air per orang sudah sangat mencukupi untuk perjalanan naik dan turun.',
            ]
        );

        $waypointsPendem = [
            [
                'name' => 'Pos 1 Kenongan',
                'altitude' => 1390,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 15, 
                'description' => 'Trek awal berupa jalanan cor semen di perkebunan warga, kemudian masuk ke hutan pinus dengan kemiringan yang landai. Vegetasi didominasi pohon pinus yang rapat, memberikan suasana teduh dan udara yang sangat sejuk.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Kendit',
                'altitude' => 1495,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 30, 
                'description' => 'Jalur mulai sedikit menanjak namun tetap didominasi tanah padat dan akar pohon. Di Pos 2 ini terdapat area yang cukup datar dengan pemandangan terbuka ke arah perbukitan di sekitar Magelang.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Alap-Alap',
                'altitude' => 1692,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 35, 
                'description' => 'Area ini merupakan puncak pertama yang dicapai dari jalur Pendem dengan area yang cukup sempit namun memanjang. Pemandangannya sangat terbuka, memperlihatkan jurang di sisi kanan-kiri dan garis jalur setapak menuju puncak utama.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Andong',
                'altitude' => 1726,
                'distance_from_prev' => 0.3, 
                'estimated_time_minutes' => 15, 
                'description' => 'Merupakan titik tertinggi (puncak utama) yang ditandai dengan tugu. Jalur menuju ke sini berupa punggungan sempit yang dikenal dengan sebutan "Jembatan Setan", dengan pemandangan langsung ke arah Gunung Merbabu dan Merapi.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Jiwa (Camp Area)',
                'altitude' => 1710,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 5, 
                'description' => 'Area ini berupa dataran yang cukup luas dan landai, menjadikannya lokasi favorit pendaki untuk mendirikan tenda. Lokasinya terletak di antara Puncak Andong dan Puncak Makam, memberikan akses mudah untuk mengejar momen matahari terbit.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsPendem as $index => $wp) {
            $pendem->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 3. VIA SAWIT
        $sawit = Route::firstOrCreate(
            ['mountain_id' => $andong->id, 'name' => 'Gunung Andong via Sawit'],
            [
                'distance' => 2.2, 
                'estimated_time' => 110, // 30+25+30+20+5
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.3820, 
                'longitude' => 110.3725
            ]
        );

        $sawit->routeInfo()->updateOrCreate(['route_id' => $sawit->id],
            [
                'basecamp_address' => 'Dusun Sawit, Desa Girirejo, Ngablak, Magelang',
                'basecamp_altitude' => 1281,
                'simaksi_price' => 20000,
                'facilities_description' => 'Basecamp Sawit merupakan gerbang utama yang sangat terorganisir dengan fasilitas lengkap. Tersedia area parkir motor yang luas dan tertutup, serta parkir mobil di halaman rumah warga. Terdapat banyak warung makan yang menyediakan logistik pendakian, toilet bersih yang tersebar di beberapa titik, serta aula atau ruang tamu luas untuk beristirahat. Selain itu, terdapat penyewaan perlengkapan pendakian seperti trekking pole dan senter bagi pendaki yang tidak membawa peralatan lengkap.',
                'logistics_description' => 'Pendaki wajib membawa persediaan air penuh dari bawah (minimal 1,5–2 liter) karena tidak ditemukan mata air di sepanjang jalur pendakian via Sawit. Kebutuhan air tambahan hanya bisa didapatkan di warung yang terletak di area puncak, namun warung ini biasanya hanya buka pada akhir pekan atau hari libur nasional. Mengingat durasi pendakian yang singkat namun terus menanjak, logistik berupa makanan ringan penambah energi sangat disarankan untuk dibawa di dalam tas harian.',
            ]
        );

        $waypointsSawit = [
            [
                'name' => 'Pos 1 Watu Pocong',
                'altitude' => 1450,
                'distance_from_prev' => 0.8, 
                'estimated_time_minutes' => 30, 
                'description' => 'Trek didominasi oleh anak tangga tanah yang tertata dan akar pohon dengan kemiringan yang cukup menguras tenaga. Vegetasi masih sangat rapat berupa hutan pinus yang memberikan keteduhan di sepanjang jalur.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Watu Gambir',
                'altitude' => 1550,
                'distance_from_prev' => 0.45, 
                'estimated_time_minutes' => 25, 
                'description' => 'Jalur terus menanjak namun terdapat area datar yang cukup untuk beristirahat sejenak di bawah pepohonan rindang. Di pos ini terdapat bangunan gazebo kecil bagi pendaki untuk berteduh jika cuaca hujan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Watu Wayang',
                'altitude' => 1680,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 30, 
                'description' => 'Trek di sini menjadi lebih terbuka dengan dominasi bebatuan besar yang dikenal sebagai Watu Wayang. Vegetasi mulai berubah dari hutan pinus menjadi semak belukar, dan dari sini pemandangan ke arah kaki gunung sudah mulai terlihat jelas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Andong',
                'altitude' => 1726,
                'distance_from_prev' => 0.35, 
                'estimated_time_minutes' => 20, 
                'description' => 'Merupakan titik tertinggi yang ditandai dengan tugu identitas Gunung Andong. Area ini sangat sempit dan memanjang, menyuguhkan pemandangan spektakuler 360 derajat ke arah Gunung Merbabu, Merapi, Sindoro, dan Sumbing.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Jiwa (Camp Area)',
                'altitude' => 1710,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 5, 
                'description' => 'Area ini berupa dataran yang paling luas di antara puncak lainnya, sehingga menjadi lokasi utama untuk mendirikan tenda. Lokasinya cukup strategis karena berada di tengah-tengah punggungan, memberikan akses mudah ke sisi matahari terbit maupun terbenam.',
                'has_water_source' => true,
            ],
        ];

        foreach ($waypointsSawit as $index => $wp) {
            $sawit->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 4. VIA GOGIK
        $gogik = Route::firstOrCreate(
            ['mountain_id' => $andong->id, 'name' => 'Gunung Andong via Gogik'],
            [
                'distance' => 2.85, 
                'estimated_time' => 155, // 35+40+35+30+15
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.3800, 
                'longitude' => 110.3750
            ]
        );

        $gogik->routeInfo()->updateOrCreate(['route_id' => $gogik->id],
            [
                'basecamp_address' => 'Dusun Gogik, Desa Girirejo, Kecamatan Ngablak, Kabupaten Magelang.',
                'basecamp_altitude' => 1250,
                'simaksi_price' => 20000,
                'facilities_description' => 'Basecamp Gogik memiliki fasilitas yang cukup lengkap dan dikelola dengan baik oleh warga setempat. Di sini tersedia area parkir kendaraan, toilet, mushola, serta tempat istirahat atau aula bagi para pendaki. Terdapat juga warung-warung yang menyediakan makanan dan minuman, serta layanan informasi mengenai kondisi jalur terbaru.',
                'logistics_description' => 'Sama seperti jalur lainnya, pendaki wajib membawa persediaan air yang cukup dari bawah (minimal 1,5–2 liter) karena tidak ada mata air yang bisa diambil di sepanjang perjalanan. Sumber air hanya tersedia di area basecamp atau dibeli di warung-warung yang berada di area puncak (biasanya hanya buka pada akhir pekan atau hari libur). Mengingat treknya yang terus menanjak, membawa logistik ringan seperti cokelat atau biskuit sangat disarankan.',
            ]
        );

        $waypointsGogik = [
            [
                'name' => 'Pos 1 Pelem',
                'altitude' => 1325,
                'distance_from_prev' => 0.9, 
                'estimated_time_minutes' => 35, 
                'description' => 'Trek awal dimulai dengan jalanan cor semen melewati ladang penduduk, kemudian mulai memasuki kawasan hutan dengan tanjakan tanah yang stabil. Vegetasi didominasi pohon-pohon rindang yang membuat suasana cukup teduh di awal pendakian.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Kendit',
                'altitude' => 1495,
                'distance_from_prev' => 0.7, 
                'estimated_time_minutes' => 40, 
                'description' => 'Jalur terus menanjak namun terdapat area datar yang cukup untuk beristirahat sejenak di bawah pepohonan rindang. Di pos ini terdapat bangunan gazebo kecil bagi pendaki untuk berteduh jika cuaca hujan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Plawangan',
                'altitude' => 1522,
                'distance_from_prev' => 0.55, 
                'estimated_time_minutes' => 35, 
                'description' => 'Ini adalah titik pertemuan antara jalur Gogik dan jalur Pendem. Karakteristiknya berupa punggungan dengan pemandangan yang mulai terbuka, di mana pendaki bisa melihat tebing puncak Andong dengan lebih jelas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Alap-Alap',
                'altitude' => 1692,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 30, 
                'description' => 'Area ini merupakan puncak pertama yang dicapai dari jalur Gogik dengan area yang cukup sempit namun memanjang. Pemandangannya sangat terbuka, memperlihatkan jurang di sisi kanan-kiri dan garis jalur setapak menuju puncak utama.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Andong',
                'altitude' => 1726,
                'distance_from_prev' => 0.3, 
                'estimated_time_minutes' => 15, 
                'description' => 'Area ini berupa dataran yang paling luas di antara puncak lainnya, sehingga menjadi lokasi utama untuk mendirikan tenda. Lokasinya cukup strategis karena berada di tengah-tengah punggungan, memberikan akses mudah ke sisi matahari terbit maupun terbenam.',
                'has_water_source' => true,
            ],
        ];

        foreach ($waypointsGogik as $index => $wp) {
            $gogik->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 5. VIA TEMU KIDUL
        $temukidul = Route::firstOrCreate(
            ['mountain_id' => $andong->id, 'name' => 'Gunung Andong via Temu Kidul'],
            [
                'distance' => 2.65, 
                'estimated_time' => 135, // 35+30+35+30+5
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.3750, 
                'longitude' => 110.3700
            ]
        );

        $temukidul->routeInfo()->updateOrCreate(['route_id' => $temukidul->id],
            [
                'basecamp_address' => 'Dusun Temu Kidul, Desa Jogoyasan, Kecamatan Ngablak, Kabupaten Magelang.',
                'basecamp_altitude' => 1150,
                'simaksi_price' => 20000,
                'facilities_description' => 'Basecamp via Temu Kidul memiliki suasana yang lebih kental dengan keramahtamahan warga lokal dan area yang cukup tenang. Fasilitas standar tersedia seperti tempat parkir motor di area rumah warga, toilet, serta mushola sederhana untuk beribadah. Meskipun tidak sekomersial jalur Sawit, di sini tetap terdapat warung warga yang menyediakan logistik dasar seperti air mineral dan makanan instan, serta area aula kayu untuk beristirahat bagi pendaki sebelum melakukan pendakian.',
                'logistics_description' => 'Sama seperti jalur lainnya di Gunung Andong, pendaki wajib membawa persediaan air penuh dari basecamp (disarankan 1,5–2 liter per orang). Tidak terdapat mata air yang bisa diambil secara bebas di sepanjang jalur Temu Kidul. Karena jalur ini memiliki elevasi yang sedikit lebih rendah dari Sawit, perjalanan akan terasa lebih panjang sedikit, sehingga membawa camilan yang mengandung gula tinggi sangat disarankan untuk menjaga energi.',
            ]
        );

        $waypointsTemukidul = [
            [
                'name' => 'Pos 1 Nganjiran',
                'altitude' => 1354,
                'distance_from_prev' => 0.9, 
                'estimated_time_minutes' => 35, 
                'description' => 'Trek awal melewati ladang penduduk kemudian masuk ke perbatasan hutan. Jalur didominasi tanah padat dengan kemiringan yang mulai terasa namun masih terlindungi oleh vegetasi yang cukup teduh.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Pelerenan',
                'altitude' => 1457,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 30, 
                'description' => 'Jalur terus menanjak namun terdapat area datar yang cukup untuk beristirahat sejenak di bawah pepohonan rindang. Di pos ini terdapat bangunan gazebo kecil bagi pendaki untuk berteduh jika cuaca hujan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Lembah Kirana',
                'altitude' => 1522,
                'distance_from_prev' => 0.55, 
                'estimated_time_minutes' => 35, 
                'description' => 'Ini adalah titik paling ikonik di jalur Temu Kidul yang terdapat kanan dan kiri jurang, berupa lembahan hijau yang sangat asri. Dari sini, vegetasi mulai terbuka dan pendaki bisa melihat kemegahan tebing Gunung Andong sebelum melakukan summit attack ke arah Puncak Alap-alap atau Puncak Jiwa.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Andong',
                'altitude' => 1726,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 30, 
                'description' => 'Merupakan titik tertinggi yang ditandai dengan tugu identitas Gunung Andong. Area ini sangat sempit dan memanjang, menyuguhkan pemandangan spektakuler 360 derajat ke arah Gunung Merbabu, Merapi, Sindoro, dan Sumbing.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Jiwa (Camp Area)',
                'altitude' => 1710,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 5, 
                'description' => 'Area ini berupa dataran yang paling luas di antara puncak lainnya, sehingga menjadi lokasi utama untuk mendirikan tenda. Lokasinya cukup strategis karena berada di tengah-tengah punggungan, memberikan akses mudah ke sisi matahari terbit maupun terbenam.',
                'has_water_source' => true,
            ],
        ];

        foreach ($waypointsTemukidul as $index => $wp) {
            $temukidul->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

    }
}
