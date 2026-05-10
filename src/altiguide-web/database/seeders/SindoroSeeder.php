<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class SindoroSeeder extends Seeder
{
    public function run(): void
    {
        $sindoro = Mountain::firstOrCreate(
            ['name' => 'Gunung Sindoro'],
            [
                'location' => 'Kab. Temanggung, Wonosobo, Jawa Tengah', 
                'altitude' => 3153,
                'description' => 'Gunung Sindoro merupakan gunung api aktif yang memiliki bentuk kerucut sempurna (stratovolcano) dan berdiri berdampingan secara megah dengan Gunung Sumbing.',
                'latitude' => -7.3000, 
                'longitude' => 110.0000, 
            ]
        );

        // ==========================================
        // 1. VIA KLEDUNG
        // ==========================================
        $kledung = Route::firstOrCreate(
            ['mountain_id' => $sindoro->id, 'name' => 'Gunung Sindoro via Kledung'],
            [
                'distance' => 7.0, 
                'estimated_time' => 450, 
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.3400, 
                'longitude' => 110.0200 
            ]
        );

        $kledung->routeInfo()->updateOrCreate(['route_id' => $kledung->id],
            [
                'basecamp_address' => 'Desa Kledung, Kecamatan Kledung (berada tepat di perbatasan antara Kabupaten Temanggung dan Kabupaten Wonosobo), Jawa Tengah.',
                'basecamp_altitude' => 1400, 
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Pos 1 (Rp 25.000) | Basecamp – Pertengahan Pos 1 & Pos 2 (Rp 40.000).',
                'facilities_description' => 'Kledung adalah jalur paling legendaris dan paling ramai untuk mendaki Sindoro. Basecamp ini sangat mudah diakses karena letaknya persis di pinggir jalan raya provinsi beraspal mulus yang membelah Sindoro dan Sumbing. Fasilitas pendukung sangat lengkap. Untuk efisiensi waktu dan energi, pengelola menyediakan layanan jasa ojek gunung yang beroperasi mengantar pendaki melintasi ladang dengan tarif Rp 25.000 sampai di Pos 1, atau Rp 40.000 jika minta diturunkan di pertengahan antara Pos 1 dan Pos 2.',
                'logistics_description' => 'Meskipun fasilitas basecamp dan warung di jalurnya sangat mewah, kelemahan utama jalur Kledung adalah ketiadaan sumber mata air alami di sepanjang trek hingga ke puncak. Pendaki diwajibkan melakukan manajemen logistik air secara mandiri dari basecamp. Untungnya, pendaki bisa membawa uang saku lebih karena terdapat beberapa warung makan yang buka di pos-pos peristirahatan.',
            ]
        );

        $waypointsKledung = [
            [
                'name' => 'Pos 1 /Pos Ojek',
                'altitude' => 1575,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 105, 
                'description' => 'Rute awal ini berfungsi sebagai pemanasan. Pendaki akan menyusuri area perkebunan sayur dan tembakau milik warga setempat. Jalurnya berupa tatanan bebatuan (makadam) yang tersusun rapi namun menanjak cukup panjang. Karena sangat menguras tenaga jika berjalan kaki, hampir sebagian besar pendaki lebih memilih memanfaatkan ojek gunung di etape ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Cawang',
                'altitude' => 1870,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Kontur jalur dari Pos 1 menuju Pos 2 Cawang tergolong masih cukup landai dan bersahabat. Pendaki mulai dinaungi oleh rindangnya pepohonan. Setibanya di Pos 2, terdapat fasilitas warung dan bangunan shelter beratap yang bisa digunakan untuk berteduh. Namun, lahan di sini sangat terbatas sehingga tidak ada area yang direkomendasikan untuk mendirikan tenda.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Seroto / Pestoroto',
                'altitude' => 2154,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 120, 
                'description' => 'Ini adalah salah satu etape terpanjang. Jalur tanah mulai menunjukkan elevasi yang jauh lebih menanjak dibanding sebelumnya. Di pertengahan rute ini, pendaki akan melintasi pos bayangan bernama Watu Longko. Pos 3 Seroto adalah lokasi camping ground yang sangat populer dan luas. Di sinilah letak Warung Mbah Kuat yang legendaris beroperasi menjajakan gorengan, buah, dan minuman hangat.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sunrise Camp',
                'altitude' => 2200,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Jika area Pos 3 sudah penuh sesak, pendaki bisa naik sedikit lagi menuju Sunrise Camp. Area kemah ini sangat ideal karena posisinya menyajikan pemandangan matahari terbit (sunrise) yang menawan dengan latar belakang kemegahan Gunung Sumbing. Lahan berdirinya tenda sangat luas dan difasilitasi dengan shelter emergency untuk kebutuhan respons cepat jika terjadi kondisi darurat (hipotermia atau cedera).',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Watu Tatah',
                'altitude' => 2500, 
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 75, 
                'description' => 'Perjalanan memasuki fase summit attack. Meninggalkan area perkemahan, jalur seketika berubah wujud menjadi tanah gersang dan tumpukan bebatuan yang lumayan terjal. Batas vegetasi pohon berangsur lenyap, berganti menjadi semak cantigi dan hamparan terbuka yang rentan diterjang angin kencang. Pos 4 Watu Tatah ini tidak memiliki area untuk bernaung maupun untuk camp.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Latar Ombo',
                'altitude' => 3153,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 120, 
                'description' => 'Trek terbuka sejauh ini didominasi oleh bebatuan vulkanik curam tanpa pepohonan pelindung. Pendaki dituntut untuk sangat berhati-hati memastikan pijakan kaki pada batu yang solid agar tidak terperosok. Begitu tanjakan ekstrem usai, bentang alam mendarat di Puncak Latar Ombo. Kawasan ini merupakan dataran puncak yang teramat luas, menyajikan panorama menakjubkan berupa lautan pasir (Segara Wedi) dan Kawah Sindoro yang aktif mengepulkan gas belerang.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsKledung as $index => $wp) {
            $kledung->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // PARSE GPX KLEDUNG
        // ==========================================
        $gpxPathKledung = database_path('data/mt-sindoro-kledung-route.gpx');
        if (file_exists($gpxPathKledung)) {
            $gpxKledung = simplexml_load_file($gpxPathKledung);
            $trackCoordinates = [];

            if (isset($gpxKledung->trk->trkseg->trkpt)) {
                foreach ($gpxKledung->trk->trkseg->trkpt as $pt) {
                    $trackCoordinates[] = [
                        (float) $pt['lat'],
                        (float) $pt['lon']
                    ];
                }
                $kledung->update(['track_coordinates' => $trackCoordinates]);
            }

            $waypointMapKledung = [
                'Post 2' => 'Pos 2 Cawang',
                'Post 3' => 'Pos 3 Seroto / Pestoroto',
                'SUNRISE CAMP' => 'Sunrise Camp',
                'Post 4 Watu tatah' => 'Pos 4 Watu Tatah',
                'Latar ombo peak' => 'Puncak Latar Ombo',
            ];

            if (isset($gpxKledung->wpt)) {
                foreach ($gpxKledung->wpt as $wpt) {
                    $gpxName = (string) $wpt->name;
                    if (isset($waypointMapKledung[$gpxName])) {
                        $kledung->waypoints()->where('name', $waypointMapKledung[$gpxName])->update([
                            'latitude' => (float) $wpt['lat'],
                            'longitude' => (float) $wpt['lon']
                        ]);
                    }
                }
            }
        }

        // ==========================================
        // 2. VIA ALANG-ALANG SEWU (PAJERO)
        // ==========================================
        $alang = Route::firstOrCreate(
            ['mountain_id' => $sindoro->id, 'name' => 'Gunung Sindoro via Alang-Alang Sewu'],
            [
                'distance' => 7.0, 
                'estimated_time' => 420, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.3400, 
                'longitude' => 110.0200 
            ]
        );

        $alang->routeInfo()->updateOrCreate(['route_id' => $alang->id],
            [
                'basecamp_address' => 'Dusun Anggrunggondok, Desa Reco, Kecamatan Kertek, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1359,
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Batas Vegetasi (Rp 25.000).',
                'facilities_description' => 'Dikenal luas dengan nama basecamp Pajero (Pasukan Jelajah Rimba), rute ini menyajikan ciri khas padang ilalang yang membentang di sekujur jalurnya. Pengelola menyertakan layanan ojek hingga ke pintu batas vegetasi seharga Rp 25.000, yang sangat efektif membantu memangkas jarak jalan kaki dari area desa menuju kawasan hutan gunung.',
                'logistics_description' => 'Manajemen rute sangat rapi. Ada inovasi unik di jalur bawah berupa anak tangga yang tepinya ditahan menggunakan kayu untuk mencegah kelongsoran. Pendaki akan menjumpai satu titik ketersediaan mata air di area menuju Pos 1 yang bisa digunakan untuk mem-pasokan botol minuman sebelum muncak.',
            ]
        );

        $waypointsAlang = [
            [
                'name' => 'Pos 1 Lembah Kesunyian',
                'altitude' => 1755,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 20, 
                'description' => 'Rute dimulai dengan track tanah modifikasi yang sangat nyaman untuk dilalui (dibingkai kayu menahan anak tangga sehingga tidak licin/tergerus). Di area inilah pendaki menemukan Patok 1 (Wiwitan/Permulaan). Terdapat total 20 patok dengan jarak acak yang berfungsi sebagai navigasi tanda batas aman.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Lembah Katresnan',
                'altitude' => 2062,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Kondisi jalur tanah mulai perlahan menanjak dengan konsisten. Pos 2 adalah area tanah datar yang sangat lapang. Titik ini sangat direkomendasikan untuk camp karena lahannya mendukung dan posisinya sebagai sumber air terakhir.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Sunrise Hunter',
                'altitude' => 2370,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 75, 
                'description' => 'Rute dari Pos 2 ke Pos 3 didominasi oleh lintasan tanah yang kian curam. Walaupun tanpa ketersediaan mata air, tempat ini sangat diminati sebagai area kemah khusus para \'pemburu sunrise\' karena view timur yang mulai sedikit demi sedikit terbuka dari rimbunnya pohon.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Jalu Mulyo',
                'altitude' => 2850,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Vegetasi perlahan berganti menjadi tanah padat bercampur bebatuan dengan dinaungi pohon-pohon lamtoro. Menguras banyak tenaga, lintasan setapak ini akan berujung pada area di mana batas kanopi daun benar-benar sirna, digantikan alam liar terbuka yang rawan hembusan angin.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Sindoro',
                'altitude' => 3153,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Ekspedisi puncak didominasi oleh jalanan berkelok di antara batu-batu super besar (boulder) dan trek berpasir debu di 30 menit terakhir. Paparan matahari terik dan sapuan angin akan sangat terasa. Mendekati kawah, aroma khas gas belerang mulai menguar pekat menandakan bahwa lautan batu di puncak Sindoro telah berhasil ditaklukkan.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsAlang as $index => $wp) {
            $alang->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // PARSE GPX ALANG-ALANG SEWU
        // ==========================================
        $gpxPathAlang = database_path('data/sindoro-via-alang-alang-sewu.gpx');
        if (file_exists($gpxPathAlang)) {
            $gpxAlang = simplexml_load_file($gpxPathAlang);
            $trackCoordinates = [];

            if (isset($gpxAlang->trk->trkseg->trkpt)) {
                foreach ($gpxAlang->trk->trkseg->trkpt as $pt) {
                    $trackCoordinates[] = [
                        (float) $pt['lat'],
                        (float) $pt['lon']
                    ];
                }
                $alang->update(['track_coordinates' => $trackCoordinates]);
            }

            $waypointMapAlang = [
                'POS 1' => 'Pos 1 Lembah Kesunyian',
                'Pos 2' => 'Pos 2 Lembah Katresnan',
                'Pos 3' => 'Pos 3 Sunrise Hunter',
                'Pos 4' => 'Pos 4 Jalu Mulyo',
                'Puncak Gunung Sindoro' => 'Puncak Sindoro',
            ];

            if (isset($gpxAlang->wpt)) {
                foreach ($gpxAlang->wpt as $wpt) {
                    $gpxName = (string) $wpt->name;
                    if (isset($waypointMapAlang[$gpxName])) {
                        $alang->waypoints()->where('name', $waypointMapAlang[$gpxName])->update([
                            'latitude' => (float) $wpt['lat'],
                            'longitude' => (float) $wpt['lon']
                        ]);
                    }
                }
            }
        }

        // ==========================================
        // 3. VIA BANSARI
        // ==========================================
        $bansari = Route::firstOrCreate(
            ['mountain_id' => $sindoro->id, 'name' => 'Gunung Sindoro via Bansari'],
            [
                'distance' => 8.0, 
                'estimated_time' => 450, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.3400, 
                'longitude' => 110.0200 
            ]
        );

        $bansari->routeInfo()->updateOrCreate(['route_id' => $bansari->id],
            [
                'basecamp_address' => 'Desa Bansari, Kecamatan Bansari, Kabupaten Temanggung, Jawa Tengah.',
                'basecamp_altitude' => 1071,
                'simaksi_price' => 35000,
                'ojek_price' => 30000,
                'ojek_description' => 'Basecamp – Pos 1 (Rp 30.000 siang | Rp 35.000 malam).',
                'facilities_description' => 'Jalur Bansari menghadirkan jalur yang cukup panjang dari ketinggian elevasi basecamp yang terbilang rendah (1071 mdpl). Namun, pihak basecamp telah menyediakan opsi evakuasi efisiensi waktu berupa ojek atau penyewaan mobil pickup yang sanggup membawa pendaki melibas jalur kebun hingga mencapai Pos 1.',
                'logistics_description' => 'Jalur dari sisi timur Sindoro ini punya kelebihan tersendiri. Berbeda dengan Kledung yang sangat kering, di jalur Bansari pendaki masih bisa menjumpai mata air segar di Pos 3 yang dapat disuplai untuk bekal berkemah di Pos 4 atau Pos 5.',
            ]
        );

        $waypointsBansari = [
            [
                'name' => 'Pos 1 Sidempul',
                'altitude' => 1576,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 105, 
                'description' => 'Lintasan teramat panjang berwujud bebatuan makadam rapi ini membelah ladang pertanian warga. Jalurnya sudah mulai memberikan tanjakan dari awal. Penggunaan ojek atau pickup sangat direkomendasikan untuk menghindari kelelahan otot betis sebelum masuk hutan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Turunan',
                'altitude' => 1886,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Rute awalnya landai bagai bonus, dan pendaki akan melintasi dasar anak sungai yang umumnya mengering di musim kemarau. Dari sana, trek berganti menjadi dominasi tanah liat licin yang cukup berbahaya saat terguyur hujan. Lahan pos sangat sempit dan tidak ideal untuk camp.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Tunggangan',
                'altitude' => 2171,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Di pos ini terdapat shelter perlindungan serta keberadaan aliran sumber mata air yang jernih. Catatan: Waspada saat musim hujan, diimbau tidak mendekat mengambil air karena debit dan arusnya bisa berubah sangat liar serta berbahaya.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Bukit Soma',
                'altitude' => 2314,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Konturnya tetap menanjak stabil. Ini merupakan salah satu area yang cukup baik untuk mendirikan tenda karena terdapat dataran yang lumayan luas. Pendaki harus mengisi persediaan jerigen air penuh-penuh di Pos 3 sebelumnya jika berniat menginap di sini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Mlelan (Camp Site)',
                'altitude' => 2715,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 120, 
                'description' => 'Inilah lokasi camping ground terbaik dan terfavorit di jalur Bansari. Berada persis di bibir pemandangan terbuka, Pos Mlelan menyuguhkan sensasi visual spektakuler jika cuaca mendukung, di mana lanskap matahari terbit (sunrise) maupun terbenam (sunset) terlihat sempurna dari depan tenda.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 6 Centhong',
                'altitude' => 3050,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 75, 
                'description' => 'Serangan puncak (summit attack) dimulai. Rute tanah liat dan batu-batuan kecil melintas di area hutan perdu pohon lamtoro. Vegetasi kemudian menipis drastis, berganti wujud menjadi hamparan rumput sabana pendek yang dihiasi taburan bunga edelweis.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Sindoro',
                'altitude' => 3153,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Etape akhir ini sangat pendek namun intens dengan trek batu kerikil dan semak cantigi. Hamparan kawah aktif, lautan pasir (Segara Wedi), dan deretan puncak gunung Jawa Tengah (Sumbing, Merapi, Merbabu, Lawu, Prau, dll) tersaji bagai lukisan panorama 360 derajat tiada dua.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsBansari as $index => $wp) {
            $bansari->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // PARSE GPX BANSARI (POTONG BASECAMP - PUNCAK)
        // ==========================================
        $gpxPathBansari = database_path('data/sindoro-bansari-sigandul.gpx');
        if (file_exists($gpxPathBansari)) {
            $gpxBansari = simplexml_load_file($gpxPathBansari);
            $trackCoordinates = [];
            $maxEle = -1;
            $peakIndex = -1;
            $currentIndex = 0;

            if (isset($gpxBansari->trk->trkseg->trkpt)) {
                foreach ($gpxBansari->trk->trkseg->trkpt as $pt) {
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

                // Potong dari awal sampai puncak saja
                if ($peakIndex > 0) {
                    $trackCoordinates = array_slice($trackCoordinates, 0, $peakIndex + 1);
                }

                $bansari->update(['track_coordinates' => $trackCoordinates]);
            }
        }

        // ==========================================
        // 4. VIA SIGEDANG (TAMBI)
        // ==========================================
        $sigedang = Route::firstOrCreate(
            ['mountain_id' => $sindoro->id, 'name' => 'Gunung Sindoro via Sigedang'],
            [
                'distance' => 6.5, 
                'estimated_time' => 390, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.3400, 
                'longitude' => 110.0200 
            ]
        );

        $sigedang->routeInfo()->updateOrCreate(['route_id' => $sigedang->id],
            [
                'basecamp_address' => 'Kawasan Kebun Teh Tambi, Kecamatan Kejajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1500,
                'simaksi_price' => 30000,
                'ojek_price' => 50000,
                'ojek_description' => 'Basecamp – Pos 2 (Ojek: Rp 50.000 | Carter Mobil Pickup: Rp 150.000 - Rp 300.000).',
                'facilities_description' => 'Jalur Sigedang memiliki fasilitas transportasi yang sangat memanjakan pendaki karena areanya melintasi kawasan Agrowisata Kebun Teh Tambi. Area pendaftaran buka secara reguler pukul 08.00 - 21.00 WIB. Halaman parkir dikelola sangat baik (Rp 10.000 untuk roda dua, Rp 20.000 roda empat). Istimewanya, ada armada mobil pickup (sewa Rp 150.000 - Rp 300.000) dan ojek (Rp 50.000) yang diizinkan memboyong pendaki membelah perkebunan teh mulus secara drastis hingga tiba di Pos 2.',
                'logistics_description' => 'Sigedang dikenal sebagai rute dengan jarak trekking tercepat (sekitar 6-7 jam total) menuju puncak Sindoro jika diakses dengan bantuan moda transportasi ke Pos 2. Namun di sisi lain, tidak ada jaminan pasokan air di sepanjang trek hutannya, jadi perbekalan botol air harus terisi maksimal dari bawah.',
            ]
        );

        $waypointsSigedang = [
            [
                'name' => 'Pos 1 Kebun Teh',
                'altitude' => 1889,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 20, 
                'description' => 'Rute pemanasan melintasi setapak yang terapit oleh hamparan tanaman teh yang sangat estetik. Konturnya sudah mulai cukup menanjak, dan layanan ojek bisa melintas dengan leluasa membelah kawasan ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Kebun Teh',
                'altitude' => 2066,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Titik akhir dari area asri perkebunan teh Tambi sekaligus pelataran akhir batas drop-off armada ojek atau mobil pickup. Pendakian sesungguhnya dengan ransel di punggung dimulai murni dari titik elevasi ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Watu Tulis (Sunrise Camp)',
                'altitude' => 2442,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Berjalan menyusuri setapak dengan akar tanaman teh yang tersisa, pendaki akan menemukan Pintu Rimba berupa patok besi, sebelum masuk ke rimbunnya hutan pohon Kasiyah. Terdapat Pos Bayangan 3, lalu 30 menit kemudian tiba di kawasan Sunrise Camp (Pos 3 Watu Tulis). Ini adalah lokasi kemah yang teramat direkomendasikan karena areanya didominasi pasir dan rumput yang agak terbuka.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Ladang Batu 1',
                'altitude' => 2734,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Melangkahkan kaki dari tempat camp, pendaki dihadapkan pada tanjakan full terbuka yang minim pepohonan pelindung. Sesuai dengan namanya, Ladang Batu 1 dikelilingi oleh formasi bebatuan koral raksasa yang menyebar di tepian rute pasir.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Ladang Batu 2',
                'altitude' => 3024,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 70, 
                'description' => 'Transisi dari Ladang Batu 1 menuju Ladang Batu 2 dipenuhi oleh jalur tanah yang sangat rawan licin jika turun hujan. Namun, tiba di Ladang Batu 2, kaki akan berpijak kembali di atas tatanan batu-batu solid besar yang menjulang kokoh tanpa khawatir merosot.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Sabana',
                'altitude' => 3100, 
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Siksaan tanjakan curam yang tak kenal ampun dinyatakan resmi berakhir saat pendaki memijakkan kaki di kawasan padang edelweis yang menenangkan mata. Ini adalah penanda pintu masuk zona atas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Larasati',
                'altitude' => 3153,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 15, 
                'description' => 'Cukup berjalan santai membelah dataran padang puncak selama 15 menit, pendaki tiba di bibir Kawah Sindoro atau Puncak Larasati. Sebuah hadiah paripurna usai menuntaskan pendakian singkat dan menantang.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsSigedang as $index => $wp) {
            $sigedang->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 5. VIA NDORO ARUM
        // ==========================================
        $ndoroArum = Route::firstOrCreate(
            ['mountain_id' => $sindoro->id, 'name' => 'Gunung Sindoro via Ndoro Arum'],
            [
                'distance' => 7.0, 
                'estimated_time' => 390, 
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.3400, 
                'longitude' => 110.0200 
            ]
        );

        $ndoroArum->routeInfo()->updateOrCreate(['route_id' => $ndoroArum->id],
            [
                'basecamp_address' => 'Dusun Banaran Kayugiyang, Kecamatan Garung, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1300,
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Pos 1 (Layanan ojek ke Pos 1).',
                'facilities_description' => 'Jalur alternatif yang punya penamaan puitis ini (gabungan Sindoro dan Bukit Arum) sangat cocok dicoba jika menginginkan suasana asri. Berada tak jauh dari pusat kota Wonosobo (sekitar 18 Km) atau Terminal Mendolo. Fasilitas basecamp lengkap dengan tarif parkir yang wajar. Pengelola juga melengkapi akses dengan penyediaan jasa ojek ke Pos 1.',
                'logistics_description' => 'Jalur ini tidak terkenal karena ketersediaan airnya. Pendaki yang memutuskan menjelajah rute Ndoro Arum wajib menyiapkan volume air yang melimpah dan mengutamakan penggunaan tas yang ringan (ultralight jika bisa) karena elevasi tanjakannya cukup panjang dan konstan.',
            ]
        );

        $waypointsNdoroArum = [
            [
                'name' => 'Pos 1 Ngrata',
                'altitude' => 1650,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Jalur pembuka didominasi aspal makadam batuan kasar, meliuk cantik menembus sentra perladangan jagung, daun bawang, dan kadang hamparan hijau daun tembakau khas Temanggung-Wonosobo. Bisa dilewati jalan kaki atau menggunakan ojek. Tiba di Pos 1 (Ngrata), area hutan pinus terbuka menyambut dengan lahan luas yang sangat asyik untuk memasang tenda atau berayun di atas hammock.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Kayu Sawa',
                'altitude' => 1900,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Perjalanan 20 menit pertama masih dibuai bonus tanah datar di sela rimbun pinus hingga bertemu Pos Bayangan Taman Ageng. Setelah itu rute berubah perlahan menanjak. Pos ini berupa batas rimba yang cukup menantang napas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Watu Putih',
                'altitude' => 2300,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Di etape ini, lutut pendaki langsung disambut Tanjakan Mrongkol yang terjal. Setelah diredam jalur mendatar, ada Pos Bayangan 3 yang amat disarankan untuk arena berkemah (camp). Posisinya tertutup rapat oleh tameng pepohonan rimba, sehingga tenda aman 100% dari terpaan badai. Pos Watu Putih berada tidak jauh dari pos bayangan tersebut.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Uci-uci',
                'altitude' => 2600,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Rute ini memiliki siksaan ikonik bernama "Tanjakan Mertua Galak", menandakan treknya yang amat curam panjang ke atas tiada ampun. Tersedia Pos Bayangan 4 di bawah untuk tenda darurat. Batas vegetasi pohon tertutup mulai musnah di area Pos Uci-uci ini, sehingga angin akan berembus leluasa ke arah jalur.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Sindoro (Via Ndoro Arum)',
                'altitude' => 3153,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Trek summit yang gersang dan terbuka penuh. Saking curamnya elevasi batuan yang memblokir langkah, pengelola jalur mengikatkan tali-tali webing pengaman sebagai alat bantu daki untuk mengamankan pijakan. Begitu tiba di puncak melalui rute ini, pendaki akan berada persis di sekitar kawasan yang sangat dikeramatkan warga, yakni Petilasan Kyai Santri. Pendakian total via Ndoro Arum dikalkulasikan mencapai 6,5 Jam.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsNdoroArum as $index => $wp) {
            $ndoroArum->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // PARSE GPX NDORO ARUM
        // ==========================================
        $gpxPathNdoroArum = database_path('data/sindoro-via-ndoro-arum.gpx');
        if (file_exists($gpxPathNdoroArum)) {
            $gpxNdoroArum = simplexml_load_file($gpxPathNdoroArum);
            $trackCoordinates = [];

            if (isset($gpxNdoroArum->trk->trkseg->trkpt)) {
                foreach ($gpxNdoroArum->trk->trkseg->trkpt as $pt) {
                    $trackCoordinates[] = [
                        (float) $pt['lat'],
                        (float) $pt['lon']
                    ];
                }
                $ndoroArum->update(['track_coordinates' => $trackCoordinates]);
            }

            $waypointMapNdoroArum = [
                'Pos 2 kayu sawa' => 'Pos 2 Kayu Sawa',
                'Pos 3 Watu Putih' => 'Pos 3 Watu Putih',
                'Pos 4 uci-uci' => 'Pos 4 Uci-uci',
                'Puncak ndoro arum' => 'Puncak Sindoro (Via Ndoro Arum)',
            ];

            if (isset($gpxNdoroArum->wpt)) {
                foreach ($gpxNdoroArum->wpt as $wpt) {
                    $gpxName = (string) $wpt->name;
                    if (isset($waypointMapNdoroArum[$gpxName])) {
                        $ndoroArum->waypoints()->where('name', $waypointMapNdoroArum[$gpxName])->update([
                            'latitude' => (float) $wpt['lat'],
                            'longitude' => (float) $wpt['lon']
                        ]);
                    }
                }
            }
        }

    }
}
