<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class MerbabuSeeder extends Seeder
{
    public function run(): void
    {
        $merbabu = Mountain::firstOrCreate(
            ['name' => 'Gunung Merbabu'],
            [
                'location' => 'Kab. Magelang, Boyolali, Semarang, Jawa Tengah', 
                'altitude' => 3142,
                'description' => 'Gunung Merbabu adalah gunung api tipe Strato yang sangat populer berkat sabana yang membentang luas serta padang edelweis yang memukau. Ketinggiannya membentang di perbatasan Magelang, Boyolali, dan Semarang. Gunung ini memiliki lima rute pendakian yang fenomenal dan memiliki karakteristiknya masing-masing.',
                'latitude' => -7.4556,  
                'longitude' => 110.4389, 
            ]
        );

        // ==========================================
        // 1. VIA SUWANTING
        // ==========================================
        $suwanting = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Gunung Merbabu via Suwanting'],
            [
                'distance' => 6.45, 
                'estimated_time' => 540, // 8-10 jam
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.4725, 
                'longitude' => 110.3705
            ]
        );

        $suwanting->routeInfo()->updateOrCreate(['route_id' => $suwanting->id],
            [
                'basecamp_address' => 'Dusun Suwanting, Desa Banyuroto, Kec. Sawangan, Kab. Magelang, Jawa Tengah.',
                'basecamp_altitude' => 1500,
                'simaksi_price' => 65000,
                'ojek_price' => 10000,
                'ojek_description' => 'Basecamp – Gerbang Pendakian (Rp 10.000 - Rp 15.000).',
                'facilities_description' => 'Basecamp Suwanting menyediakan fasilitas yang memadai untuk tempat istirahat pendaki sebelum memulai perjalanan. Tersedia pos pendaftaran resmi (Simaksi), area parkir kendaraan, dan toilet umum/kamar mandi. Di area sekitar basecamp juga terdapat warung-warung warga yang menyediakan makanan hangat, air mineral, serta perlengkapan logistik darurat. Selain itu, terdapat jasa porter dan penyewaan alat jika pendaki membutuhkan bantuan tambahan. Disediakan juga jasa ojek dari Basecamp menuju Gerbang Pendakian (pintu rimba) dengan tarif Rp 10.000 - Rp 15.000 sekali jalan.',
                'logistics_description' => 'Jalur pendakian ini kurang cocok bagi pendaki pemula karena penuh tanjakan sejak awal pendakian tanpa landaian yang berarti. Kemiringan rata-rata mencapai 30,8 derajat, menjadikannya salah satu rute paling berat dan menguras tenaga. Keunikannya adalah adanya patok penanda di sepanjang jalur setiap 100 meter. Anda wajib mengatur logistik dan asupan cairan dengan matang, karena sumber air krusial hanya ada di Pos Air (sebelum Pos 3).',
            ]
        );

        $waypointsSuwanting = [
            [
                'name' => 'Pos 1 Lembah Lempong',
                'altitude' => 1555,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 5, 
                'description' => 'Rute pintu hutan ke Pos 1 merupakan jalur dengan jarak terpendek di Suwanting. Vegetasi masih didominasi hutan pinus, dengan tanaman semak dan rumput. Pos berupa tanah datar yang tidak terlalu luas dan tidak ada selter.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Bendera',
                'altitude' => 2186,
                'distance_from_prev' => 2.0, 
                'estimated_time_minutes' => 135, // 2-2.5 jam
                'description' => 'Pendakian sesungguhnya dimulai. Jalur cukup panjang dan mulai menanjak konstan melintasi beberapa Lembah (Lembah Gosong, Cemoro, Ngrijan, dan Mitoh). Trek curam, berlumpur saat hujan dan berdebu saat kemarau. Menjadi alternatif camp bagi yang kelelahan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos Air Tengah Jalur',
                'altitude' => 2665,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 165, // 2.5-3 jam
                'description' => 'Bagian terberat dan paling terjal sejauh pendakian ini. Terdapat tali-tali webbing yang diikatkan di pohon untuk pegangan. Terdapat pasokan gentong air peralon yang sangat menolong pendaki yang kehausan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Dampo Awang',
                'altitude' => 2740,
                'distance_from_prev' => 0.2, 
                'estimated_time_minutes' => 20, 
                'description' => 'Lahan sangat luas berkapasitas puluhan tenda, sekaligus menjadi home base ideal untuk bermalam sebelum menuju puncak. Karena tidak ada pohon besar, Anda wajib waspada angin kencang.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Suwanting',
                'altitude' => 3105,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 75, // 1-1.5 jam
                'description' => 'Sebenarnya merupakan ujung punggungan jalur Suwanting setelah melewati tiga hamparan Sabana (Sabana 1, 2, dan 3) yang sangat mengagumkan. Trek tanah yang konstan dan didera angin badai gunung.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Triangulasi',
                'altitude' => 3142,
                'distance_from_prev' => 0.25, 
                'estimated_time_minutes' => 15, 
                'description' => 'Hanya berjarak sangat dekat dari puncak Suwanting dengan kontur sedikit naik-turun yang bersahabat. Di sini berdiri tugu beton Triangulasi.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Kenteng Songo',
                'altitude' => 3142,
                'distance_from_prev' => 0.15, 
                'estimated_time_minutes' => 5, 
                'description' => 'Titik pertemuan jalur Suwanting dengan jalur besar lainnya (Sel, Wekas, Thekelan). Terdapat batu lumpang legenda yang berlubang di puncak puncaknya.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsSuwanting as $index => $wp) {
            $suwanting->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 2. VIA SELO
        // ==========================================
        $selo = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Gunung Merbabu via Selo'],
            [
                'distance' => 5.75, 
                'estimated_time' => 450, // 6-8 jam
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.4912, 
                'longitude' => 110.4501
            ]
        );

        $selo->routeInfo()->updateOrCreate(['route_id' => $selo->id],
            [
                'basecamp_address' => 'Dusun Genting, Desa Tarubatang, Kec. Selo, Kab. Boyolali, Jawa Tengah.',
                'basecamp_altitude' => 1800,
                'simaksi_price' => 65000,
                'ojek_price' => null,
                'ojek_description' => 'Tidak ada akses ojek di dalam trek pendakian.',
                'facilities_description' => 'Sangat lengkap. Terdapat banyak warung warga yang buka hingga malam/24 jam, menyediakan makanan berat (soto, nasi rames, mie), aneka minuman, dan tambahan logistik pendakian. Tersedia tempat penyewaan perlengkapan outdoor (tenda, matras, sleeping bag, dll) serta layanan jasa porter lokal di sekitar area basecamp. Fasilitas pendukung seperti area parkir luas, mushola, toilet, dan toko souvenir.',
                'logistics_description' => 'Jalur eksotis ini menuntut manajemen perbekalan air yang cermat karena sama sekali tidak ada mata air alami di rute ini. Elevasinya tidak securam jalur lain dan sabana hijau menantinya di bagian atas, membuat Selo menjadi jalur paling terkenal dan paling direkomendasikan bagi pendaki pemula, asal kuota pendakian tersedia.',
            ]
        );

        $waypointsSelo = [
            [
                'name' => 'Pos 1 Dok Malang',
                'altitude' => 2189,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 90, 
                'description' => 'Perjalanan santai yang cocok untuk pemanasan melintasi perkebunan warga. Selanjutnya masuk sedikit ke batas hutan primer berkanopi pinus.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Simpang Macan',
                'altitude' => 2270,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 45, 
                'description' => 'Bukanlah pos beristirahat panjang, namun tempat mengatur napas sejenak sebelum menghadapi medan yang mulai menyempit dan curam.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Pandean',
                'altitude' => 2412,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 40, 
                'description' => 'Area yang mulai menuntut ekstra tenaga. Trek bertambah drastis curamnya dan pendaki sudah harus menggunakan bantuan akar pohon untuk naik.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Batu Tulis',
                'altitude' => 2595,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 40, 
                'description' => 'Tempat beristirahat terakhir sebelum menyebrang area batas hutan rimbun menuju ke lanskap terbuka Merbabu yang sesungguhnya.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sabana 1',
                'altitude' => 2750,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 60, 
                'description' => 'Perjuangan melewari "Tanjakan PHP", akan disambut oleh padang rumput sabana luar biasa indah yang lapang tak terhalang pohon.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sabana 2',
                'altitude' => 2850,
                'distance_from_prev' => 0.3, 
                'estimated_time_minutes' => 30, 
                'description' => 'Spot paling populer untuk mendirikan tenda dan foto bagi para pengunjung Gunung Merbabu jalur rute Selo.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Triangulasi / Kenteng Songo',
                'altitude' => 3142,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 90, 
                'description' => 'Memasuki tahap bukit curam "summit attack" yang menyiksa sendi dan berdebu berat berhias lembah tebing kanan kirinya.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsSelo as $index => $wp) {
            $selo->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 3. VIA WEKAS
        // ==========================================
        $wekas = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Gunung Merbabu via Wekas'],
            [
                'distance' => 5.5, 
                'estimated_time' => 400, // 6-7 jam
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.4201, 
                'longitude' => 110.4201
            ]
        );

        $wekas->routeInfo()->updateOrCreate(['route_id' => $wekas->id],
            [
                'basecamp_address' => 'Dusun Wekas, Desa Kaponan, Kec. Pakis, Kab. Magelang, Jawa Tengah.',
                'basecamp_altitude' => 1550,
                'simaksi_price' => 65000,
                'ojek_price' => 15000,
                'ojek_description' => 'Basecamp – Merbabu Pass / Pintu Hutan (Rp 15.000 - Rp 30.000).',
                'facilities_description' => 'Fasilitas di Basecamp Wekas sangat mendukung kenyamanan pendaki. Terdapat warung-warung warga yang menyediakan makanan rumahan, kopi, dan camilan yang buka hampir 24 jam. Tersedia juga area parkir luas, toilet, mushola, serta tempat istirahat sementara (shelter). Tersedia jasa porter dan sewa alat, serta layanan ojek pendakian ke arah Merbabu Pass (pos akhir kebun warga).',
                'logistics_description' => 'Keunggulan utama Wekas adalah treknya yang paling pendek jika dibandingkan rute Merbabu lainnya. Jalurnya bertemu dengan jalur Thekelan nantinya di tengah. Salah satu keistimewaannya juga adalah ketersediaan sumber air yang mengalir melimpah di Pos 2.',
            ]
        );

        $waypointsWekas = [
            [
                'name' => 'Merbabu Pass (Pintu Hutan)',
                'altitude' => 1858,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 20, 
                'description' => 'Perbukitan sempit sebagai garis batas alam. Aksesnya kombinasi jalan cor dari desa terdekat (dapat ditempuh opsi memakai Ojek 15rb-30rb).',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 1 Tegal Arum',
                'altitude' => 2117,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 75, // 1-1.5 jam
                'description' => 'Menyusur jalan tanah sempit yang melewati rimbun pinus hutan dan pipa perairan irigasi. Terdapat shelter berupa gazebo kecil tanpa lahan luas untuk tenda.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Wekas / Kidang Kencana',
                'altitude' => 2480,
                'distance_from_prev' => 1.4, 
                'estimated_time_minutes' => 105, // 1.5-2 jam
                'description' => 'Mendaki medan yang teramat curam hampir tanpa henti (sebelum HM 20). Setelah itu masuk ke hamparan Pos 2 super lapang dengan pipa air kencang utama untuk seluruh pendaki.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Watu Kumpul',
                'altitude' => 2821,
                'distance_from_prev' => 0.8, 
                'estimated_time_minutes' => 50, 
                'description' => 'Melewati cerukan bongkahan bekas batu kawah raksasa (bukti Merbabu ialah gunung vulkanis). Ekosistem semak cantigi terbentang mendominasi.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Tugu Perbatasan Kabupaten',
                'altitude' => 2847,
                'distance_from_prev' => 0.1, 
                'estimated_time_minutes' => 15, 
                'description' => 'Perjalanan menapaki rute Thekelan. Tersaji area luas yang secara administratif menjadi patok tapal batas dari ketiga kabupaten: Magelang, Boyolali, Semarang.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pertigaan Helipad & Geger Sapi',
                'altitude' => 3002,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 25, 
                'description' => 'Dataran mendarat helikopter serta Puncak Geger Sapi. Titik di atas formasi punuk sapi gunung. Lanjut menanjak menggiurkan sampai ke persimpangan jalur.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Syarif & Ondo Rante',
                'altitude' => 3119,
                'distance_from_prev' => 0.4, 
                'estimated_time_minutes' => 20, 
                'description' => 'Anda bisa memilih puncak Syarif di sisi kiri, atau melanjutkan penderitaan di jembatan bukit terbuka jalur Ondo Rante untuk meraih Puncak Tertinggi Merbabu berikutnya.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Kenteng Songo',
                'altitude' => 3142,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 45, 
                'description' => 'Jalur ngeri dan seram memanjat lereng Jembatan Setan dengan bantuan pagar penuntun serta tebing sedada penanjak (Knee to Chin trek).',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsWekas as $index => $wp) {
            $wekas->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 4. VIA THEKELAN
        // ==========================================
        $thekelan = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Gunung Merbabu via Thekelan'],
            [
                'distance' => 6.0, 
                'estimated_time' => 480, // 7-9 jam
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.4050, 
                'longitude' => 110.4285
            ]
        );

        $thekelan->routeInfo()->updateOrCreate(['route_id' => $thekelan->id],
            [
                'basecamp_address' => 'Dusun Thekelan, Desa Batur, Kec. Getasan, Kab. Semarang, Jawa Tengah.',
                'basecamp_altitude' => 1560,
                'simaksi_price' => 65000,
                'ojek_price' => null,
                'ojek_description' => 'Basecamp – Pos 1 (Tarif tidak disebutkan spesifik di data).',
                'facilities_description' => 'Sebagai jalur pendakian tertua, fasilitas di Basecamp Thekelan sangat mapan dan dikelola dengan baik. Terdapat balai atau aula luas yang bisa menampung rombongan pendaki untuk tidur atau beristirahat sebelum mendaki. Area parkir sangat memadai, dilengkapi dengan toilet bersih, kamar mandi, dan jajaran warung makan yang cukup lengkap. Penyewaan perlengkapan pendakian (outdoor gear) dan jasa porter juga sangat mudah',
                'logistics_description' => 'Thekelan ialah rute dengan perjalanan 7 Puncak Legenda Merbabu (Seven Summits). Meski di Pos 1 dan 2 dimanjakan kran air, pendaki mutlak wajib membawa persediaan cadangan karena lama panjangnya durasi menyeberangi kawasan puncak satu ke puncak lainnya.',
            ]
        );

        $waypointsThekelan = [
            [
                'name' => 'Pos 1 Lintas Kebun',
                'altitude' => 1700,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 45, 
                'description' => 'Bagian termudah menyusuri paving dan jalan batu makadam melintasi desa (tersedia ojek lokal). Dilengkapi mata air bersih dan pondok luas di sebelahnya.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Gerbang Cendani',
                'altitude' => 2050,
                'distance_from_prev' => 0.85, 
                'estimated_time_minutes' => 75, 
                'description' => 'Masuk hutan rindang dengan naungan bambu liar merambat. Anda juga dapat mengambil pasokan air bersih dari aliran alam yang difasilitasi selang masyarakat.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Sabarnak',
                'altitude' => 2361,
                'distance_from_prev' => 1.1, 
                'estimated_time_minutes' => 75, 
                'description' => 'Medan bukit berkelok zig zag. Berada cukup jauh dari basecamp, terdapat opsi membuka tenda di celah lembahan bukit untuk meminimalisir terjangan badai.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Lempong Sampan',
                'altitude' => 2847,
                'distance_from_prev' => 0.46, 
                'estimated_time_minutes' => 40, 
                'description' => 'Ciri khas trek hutan pinus kering sisa insiden karhutla pada tahun lampau, dengan tanah gambut dan jejeran cantigi serta padang edelweiss.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Watu Gubuk (Puncak 1)',
                'altitude' => 2860,
                'distance_from_prev' => 0.71, 
                'estimated_time_minutes' => 50, 
                'description' => 'Titik awalan 7 susunan puncak. Sebuah batuan eksotis menyerupai gubuk primitif.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Pemancar (Puncak 2)',
                'altitude' => 2880,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 30, 
                'description' => 'Dahulu terdapat konstruksi menara komunikasi tegak berdiri, rute ini terhubung persimpangan dengan rute Cuntel.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Geger Sapi (Puncak 3)',
                'altitude' => 3002,
                'distance_from_prev' => 0.46, 
                'estimated_time_minutes' => 40, 
                'description' => 'Hamparan dataran Helipad ke arah gundukan mirip bentuk punuk hewan sapi lokal Gunung Merbabu.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Syarif (Puncak 4)',
                'altitude' => 3137,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 60, 
                'description' => 'Melangkah via tebing menuju percabangan dua arah jurang dalam, ambilah laju tebing miring kiri merapat pada dinding pasir tebal ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Ondo Rante (Puncak 5)',
                'altitude' => 3140,
                'distance_from_prev' => 0.3, 
                'estimated_time_minutes' => 20, 
                'description' => 'Kembali bermanuver putar arah, ini merupakan punggungan tajam ke perbukitan raksasa tengah.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Kenteng Songo & Triangulasi (Pk. 6 & 7)',
                'altitude' => 3142,
                'distance_from_prev' => 0.6, 
                'estimated_time_minutes' => 55, 
                'description' => 'Dua pilar besar puncak terakhir sebagai atap kesuksesan misi Thekelan di ujung tertinggi Merbabu.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsThekelan as $index => $wp) {
            $thekelan->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 5. VIA GANCIK
        // ==========================================
        $gancik = Route::firstOrCreate(
            ['mountain_id' => $merbabu->id, 'name' => 'Gunung Merbabu via Gancik'],
            [
                'distance' => 5.5, 
                'estimated_time' => 360, // 5-7 jam (cepatt/tektok)
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.4930, 
                'longitude' => 110.4350
            ]
        );

        $gancik->routeInfo()->updateOrCreate(['route_id' => $gancik->id],
            [
                'basecamp_address' => 'Dusun Gancik, Desa Selo, Kec. Selo, Kab. Boyolali, Jawa Tengah. (Area Gancik Hill Top).',
                'basecamp_altitude' => 1850,
                'simaksi_price' => 60000,
                'ojek_price' => 20000,
                'ojek_description' => 'Basecamp – Pos Rimba (Rp 20.000) | Basecamp – Pos 1 (Rp 30.000 - Rp 50.000).',
                'facilities_description' => 'Fasilitas basecamp dikelola secara swadaya oleh masyarakat. Area parkir cukup luas menampung kendaraan roda dua dan empat. Tersedia juga warung-warung makan, tempat istirahat sementara, dan toilet. Suasana basecamp cenderung lebih santai dan fleksibel dibandingkan pos resmi, bahkan registrasi on-the-spot kerap difasilitasi di jam-jam non rasional malam.',
                'logistics_description' => 'Daya tarik masif dari desa Gancik adalah sangat difavoritkannya demi memangkas durasi pendakian TekTok (Lintas harian). Pendaki disuguhi jasa Ojek ekstrim melahap elevasi aspal, menjadikan gowes ke pos Sabana memakan sekian ratus menit belaka.',
            ]
        );

        $waypointsGancik = [
            [
                'name' => 'Pos 1 Hutan',
                'altitude' => 2050,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 90, // jalan kaki
                'description' => 'Bantalan semen tajam dan kebun warga nan eksotis. Pendaki kerap memakai ojek gila modifikasi maut demi menebas durasi di sini jadi puluhan menit saja.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Merapi View',
                'altitude' => 2100,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 60, 
                'description' => 'Sepanjang setapak ini Merapi nampak menampakkan tajuk vulkanik kembar. Tiupan hawa menabrak wajah pendaki dengan brutal sebab bukit menonjol.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Join Selo',
                'altitude' => 2400,
                'distance_from_prev' => 0.8, 
                'estimated_time_minutes' => 60, 
                'description' => 'Pertemuan absolut antar dua belah punggung dengan lajur Selo Tarubatang. Titik bertemunya arus pendaki.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sabana 1 & 2',
                'altitude' => 2850,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 90, 
                'description' => 'Berlari-lari menikmati luasnya padang rumput memanjakan retina. Edelweis menjadi primadona menutupi lembah surya di dataran tinggi hijau Jawa Tengah.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Triangulasi / Kenteng Songo',
                'altitude' => 3142,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 105, 
                'description' => 'Summit attack ganas! Curam bebatuan kering. Merbabu di hadapan semesta.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsGancik as $index => $wp) {
            $gancik->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

    }
}
