<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class UngaranSeeder extends Seeder
{
    public function run(): void
    {
        // 1. MOUNTAIN UNGARAN
        $ungaran = Mountain::firstOrCreate(
            ['name' => 'Gunung Ungaran'],
            [
                'location' => 'Kabupaten Semarang, Jawa Tengah', 
                'altitude' => 2050,
                'description' => 'Gunung Ungaran adalah gunung berapi bertipe stratovolcano yang terletak di Kabupaten Semarang, Jawa Tengah. Gunung Ungaran memiliki kawasan hutan Dipterokarp Bukit, hutan Dipterokarp Atas, hutan Montane, dan hutan Ericaceous atau hutan gunung. Terdapat beberapa rute pendakian populer seperti Mawar, Perantunan, dan Promasan.',
                'latitude' => -7.186667, 
                'longitude' => 110.342222,
            ]
        );

        // 2. VIA PERANTUNAN
        $perantunan = Route::firstOrCreate(
            ['mountain_id' => $ungaran->id, 'name' => 'Gunung Ungaran via Perantunan'],
            [
                'distance' => 3.8, 
                'estimated_time' => 165, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.2188, 
                'longitude' => 110.3541
            ]
        );

        $perantunan->routeInfo()->updateOrCreate(['route_id' => $perantunan->id],
            [
                'basecamp_address' => 'Jalan Gintungan-Bandungan, Dusun Gintungan, Desa Bandungan, Kecamatan Bandungan, Kabupaten Semarang',
                'basecamp_altitude' => 1285,
                'simaksi_price' => 40000,
                'facilities_description' => 'Basecamp Perantunan sangat luas dan tertata modern. Tersedia area parkir yang sangat memadai untuk motor dan mobil, banyak toilet bersih, mushola, serta deretan warung yang menyediakan makanan khas daerah Bandungan. Keunggulan utama basecamp ini adalah adanya area khusus penyewaan alat outdoor yang lengkap, mulai dari tenda hingga sleeping bag, serta terdapat aula pertemuan dan spot foto di sekitar gerbang pendakian.',
                'logistics_description' => 'Pendaki wajib membawa air penuh dari bawah karena di sepanjang jalur pendakian via Perantunan tidak terdapat sumber mata air yang bisa diambil. Meskipun di Puncak Bondolan terkadang ada pedagang pada hari libur, ketersediaannya tidak bisa dipastikan. Mengingat karakter jalur yang terus menanjak dan terbuka di bagian atas, disarankan membawa minimal 2-3 liter air per orang jika berniat untuk menginap di Puncak Bondolan.',
            ]
        );

        $waypointsPerantunan = [
            [
                'name' => 'Pos 1 Watu Omah',
                'altitude' => 1414,
                'distance_from_prev' => 0.63, 
                'estimated_time_minutes' => 20, 
                'description' => 'Trek awal berupa jalan setapak tanah yang sudah tertata rapi di tengah hutan pinus. Dinamakan Watu Omah karena terdapat batu besar yang menyerupai rumah, areanya cukup teduh dan landai untuk pemanasan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Watu Jajar',
                'altitude' => 1487,
                'distance_from_prev' => 0.3, 
                'estimated_time_minutes' => 10, 
                'description' => 'Jalur mulai menanjak dengan vegetasi hutan yang lebih beragam dan rapat. Terdapat deretan batu alami yang berjajar di pinggir jalur, areanya tidak terlalu luas namun cukup untuk istirahat sejenak.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos Watu Srumpuk',
                'altitude' => 1584,
                'distance_from_prev' => 0.41, 
                'estimated_time_minutes' => 20, 
                'description' => 'Tanjakan semakin curam dengan pijakan berupa akar dan tanah padat. Vegetasi masih cukup rimbun sehingga pendaki masih terlindungi dari sinar matahari langsung.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Kolo Keciko',
                'altitude' => 1751,
                'distance_from_prev' => 0.43,
                'estimated_time_minutes' => 30,
                'description' => 'Area ini merupakan batas antara hutan rapat dan vegetasi yang mulai terbuka. Treknya cukup terjal, dan dari sini Anda mulai bisa melihat pemandangan ke arah Rawa Pening dan kota Ambarawa jika menoleh ke belakang.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Tanjakan Cinta',
                'altitude' => 1890,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 30,
                'description' => 'Sesuai namanya, pos ini berupa tanjakan panjang dan terjal tanpa bonus landai. Vegetasi sudah mulai berubah menjadi semak belukar dan rumput yang tidak setinggi sebelumnya.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Bondolan (camp)',
                'altitude' => 1885, 
                'distance_from_prev' => 0.8,
                'estimated_time_minutes' => 30,
                'description' => 'Merupakan area datar yang sangat luas dan menjadi lokasi utama pendaki untuk berkemah. Dari sini terlihat jelas pemandangan Gunung Merapi, Merbabu, Telomoyo, serta pemandangan lampu kota saat malam hari.',
                'has_water_source' => false, 
            ],
            [
                'name' => 'Puncak Botak',
                'altitude' => 2050,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 25,
                'description' => 'Jalur menuju ke sini mulai meninggalkan batas hutan (vegetasi terbuka). Trek didominasi rumput dan batuan lepas (kerikil) yang cukup licin. Puncaknya ditandai dengan area terbuka tanpa pohon besar, sehingga dinamakan Puncak Botak.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsPerantunan as $index => $wp) {
            $perantunan->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 2b. PARSE GPX UNTUK UNGARAN VIA PERANTUNAN
        $gpxPath = database_path('data/ungaran-via-perantunan.gpx');
        if (file_exists($gpxPath)) {
            $gpx = simplexml_load_file($gpxPath);
            
            // Ekstrak garis jalur (track points)
            $trackCoordinates = [];
            if (isset($gpx->trk->trkseg->trkpt)) {
                foreach ($gpx->trk->trkseg->trkpt as $pt) {
                    $trackCoordinates[] = [
                        (float) $pt['lat'],
                        (float) $pt['lon']
                    ];
                }
                $perantunan->update(['track_coordinates' => $trackCoordinates]);
            }

            // Pemetaan nama Waypoint di GPX ke nama Waypoint di Database
            $waypointMap = [
                'Pos 1 Watu Omah' => 'Pos 1 Watu Omah',
                'Pos 2 Watu Jajar' => 'Pos 2 Watu Jajar',
                'Pos 3' => 'Pos Watu Srumpuk',
                'Pos 4' => 'Pos 4 Kolo Keciko',
                'Ondo Rante' => 'Pos 5 Tanjakan Cinta', 
                'Puncak Bondolan' => 'Puncak Bondolan (camp)',
                'Puncak Botak' => 'Puncak Botak',
            ];

            // Update koordinat waypoints
            if (isset($gpx->wpt)) {
                foreach ($gpx->wpt as $wpt) {
                    $gpxName = (string) $wpt->name;
                    $lat = (float) $wpt['lat'];
                    $lon = (float) $wpt['lon'];

                    if (isset($waypointMap[$gpxName])) {
                        $dbName = $waypointMap[$gpxName];
                        $perantunan->waypoints()->where('name', $dbName)->update([
                            'latitude' => $lat,
                            'longitude' => $lon
                        ]);
                    }
                }
            }
        }

        // 3. VIA MAWAR
        $mawar = Route::firstOrCreate(
            ['mountain_id' => $ungaran->id, 'name' => 'Gunung Ungaran via Mawar'],
            [
                'distance' => 4.5, 
                'estimated_time' => 205, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.1991,  
                'longitude' => 110.3541
            ]
        );

        $mawar->routeInfo()->updateOrCreate(['route_id' => $mawar->id],
            [
                'basecamp_address' => 'Dusun Sidomukti, Desa Sidomukti, Kecamatan Bandungan, Kabupaten Semarang',
                'basecamp_altitude' => 1285,
                'simaksi_price' => 25000,
                'facilities_description' => "Basecamp Mawar merupakan salah satu basecamp paling komersial dan lengkap di Jawa Tengah. Fasilitasnya mencakup area parkir bertingkat yang sangat luas, toilet dan kamar mandi yang banyak, mushola, serta deretan warung yang buka 24 jam. Terdapat area perkemahan (camping ground) di bawah naungan pohon pinus yang luas, serta tempat penyewaan alat pendakian yang sangat lengkap mulai dari tenda, sleeping bag, hingga kompor.",
                'logistics_description' => "Jalur via Mawar adalah rute yang paling aman soal ketersediaan air karena terdapat mata air melimpah di Pos 3. Pendaki tidak wajib membawa air penuh dari bawah, namun disarankan tetap membawa botol kosong untuk diisi ulang di jalur. Untuk logistik, jalur ini memiliki banyak warung di basecamp dan terkadang pedagang asongan di titik-titik tertentu pada hari libur, namun tetap disarankan membawa bekal makanan yang cukup karena trek setelah Pos 3 akan menjadi sangat terjal dan menguras tenaga.",
            ]
        );

        $waypointsMawar = [
            [
                'name' => 'Pos 1 Bedengan',
                'altitude' => 1410,
                'distance_from_prev' => 0.85, 
                'estimated_time_minutes' => 25, 
                'description' => 'Jalur berupa jalan setapak tanah yang lebar dan sangat landai melewati hutan pinus yang asri. Kondisi trek sangat nyaman dan sering digunakan untuk jalan santai bagi pengunjung umum.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Kinatar',
                'altitude' => 1460,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 20, 
                'description' => 'Jalur masih didominasi hutan tropis dan tetap landai. Vegetasi di sini sangat rapat, memberikan suasana sejuk dan terlindung dari sinar matahari.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos Pronojiwo', 
                'altitude' => 1520,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 15, 
                'description' => 'Area istirahat paling luas sebelum tanjakan ekstrem. Terdapat tempat duduk kayu dan sumber air jernih yang terus mengalir, menjadikannya titik refill utama para pendaki.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Bukak’an',
                'altitude' => 1700,
                'distance_from_prev' => 0.8,
                'estimated_time_minutes' => 45,
                'description' => 'Sesuai namanya, vegetasi mulai terbuka dan trek berubah drastis menjadi tanjakan tanah merah yang sangat terjal tanpa bonus. Pendaki mulai terpapar sinar matahari langsung di sini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Tedeng',
                'altitude' => 1880,
                'distance_from_prev' => 0.6,
                'estimated_time_minutes' => 40,
                'description' => 'Area ikonik di mana trek terdiri dari batuan terjal yang harus dilewati dengan bantuan tali (webbing). Tanjakan di sini sangat menguras tenaga dengan kemiringan yang ekstrem.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Tanggul Angin',
                'altitude' => 1876,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 20,
                'description' => 'Puncak pertama yang menyuguhkan pemandangan ke arah Kebun Teh Promasan di bawah. Areanya cukup terbuka dan sering dijadikan tempat istirahat sebelum lanjut ke punggungan puncak utama.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Batu',
                'altitude' => 1908,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 25,
                'description' => 'Jalur menyusuri punggungan berbatu yang memanjang. Angin di sini biasanya bertiup kencang karena vegetasi hanya berupa perdu dan rumput pendek.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Banteng Raider',
                'altitude' => 2050,
                'distance_from_prev' => 0.3,
                'estimated_time_minutes' => 15,
                'description' => 'Merupakan titik tertinggi Ungaran yang ditandai dengan tugu atau benteng kecil milik TNI. Pemandangannya mencakup sisi utara laut Jawa hingga deretan gunung di Jawa Tengah bagian barat.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsMawar as $index => $wp) {
            $mawar->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // PARSE GPX MAWAR
        // ==========================================
        $gpxPathMawar = database_path('data/mt-ungaran-via-mawar-umbul-sidomukti.gpx');
        if (file_exists($gpxPathMawar)) {
            $gpxMawar = simplexml_load_file($gpxPathMawar);
            
            $trackCoordinates = [];
            $maxEle = -1;
            $peakIndex = -1;
            $currentIndex = 0;

            if (isset($gpxMawar->trk->trkseg->trkpt)) {
                foreach ($gpxMawar->trk->trkseg->trkpt as $pt) {
                    $ele = (float) $pt->ele;
                    if ($ele > $maxEle) {
                        $maxEle = $ele;
                        $peakIndex = $currentIndex;
                    }
                    $trackCoordinates[] = [
                        (float) $pt['lat'],
                        (float) $pt['lon']
                    ];
                    $currentIndex++;
                }

                // Sesuai request: Ambil dari puncak sampai basecamp, lalu REVERSE
                if ($peakIndex > 0) {
                    $descentTrack = array_slice($trackCoordinates, $peakIndex);
                    $trackCoordinates = array_reverse($descentTrack);
                }

                $mawar->update(['track_coordinates' => $trackCoordinates]);
            }

            $waypointMapMawar = [
                'POS 1' => 'Pos 1 Bedengan',
                'POS2' => 'Pos 2 Kinatar',
                'POS3 new route' => 'Pos Pronojiwo',
                'POS3 - tea plantation' => 'Pos Pronojiwo',
                'POS4' => 'Pos 4 Bukak’an',
                'Summit' => 'Puncak Banteng Raider',
            ];

            if (isset($gpxMawar->wpt)) {
                foreach ($gpxMawar->wpt as $wpt) {
                    $gpxName = (string) $wpt->name;
                    $lat = (float) $wpt['lat'];
                    $lon = (float) $wpt['lon'];

                    if (isset($waypointMapMawar[$gpxName])) {
                        $dbName = $waypointMapMawar[$gpxName];
                        $mawar->waypoints()->where('name', $dbName)->update([
                            'latitude' => $lat,
                            'longitude' => $lon
                        ]);
                    }
                }
            }
        }

    }
}
