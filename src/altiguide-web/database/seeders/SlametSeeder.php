<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class SlametSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slamet = Mountain::firstOrCreate(
            ['name' => 'Gunung Slamet'],
            [
                'location' => 'Sawah Dan Kebun, Gunungsari, Kec. Pulosari, Kabupaten Pemalang, Jawa Tengah',
                'altitude' => 3428,
                'description' => 'Gunung Slamet (3.428 mdpl) adalah gunung berapi aktif tertinggi di Jawa Tengah dan kedua tertinggi di Pulau Jawa, sering dijuluki "Atap Jawa Tengah". Berlokasi di lima kabupaten (Banyumas, Pemalang, Tegal, Brebes, Purbalingga), gunung ini populer untuk pendakian ekstrim dan ekowisata',
                'latitude' => -7.239344828010259,
                'longitude' =>  109.21453003544529,
            ]
            );
        $bambangan = Route::firstOrCreate(
            ['mountain_id' => $slamet->id, 'name' => 'Gunung Slamet via Bambangan'],
            [
                'distance' => 7.7,
                'estimated_time' => 600, // 10 jam dalam menit
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.226027520383221, 
                'longitude' => 109.26484551030069
            ]
            );
        $bambangan->routeInfo()->updateOrCreate(['route_id' => $bambangan->id],
            [
                'basecamp_address' => 'Desa Bambangan, Kutabawa, Kec. Karangreja, Kabupaten Purbalingga, Jawa Tengah 53357',
                'basecamp_altitude' => 1502,
                'simaksi_price' => 25000,
                'ojek_price' => 70000,
                'ojek_description' => 'Basecamp – Pos 1 (Sekitar Rp 70.000).',
                'facilities_description' => "Area basecamp Bambangan menyediakan fasilitas awal yang baik sebelum mulai mendaki, di mana pendaki harus menyelesaikan urusan administrasi terlebih dahulu. Syarat utamanya adalah membawa surat keterangan sehat; jika tidak membawanya dari rumah, kamu diwajibkan membuat surat pernyataan yang dibubuhi materai Rp 10.000. Di sekitar basecamp, pendaki juga dapat menyewa jasa ojek untuk mempercepat perjalanan menuju Pos 1 dengan tarif sekitar Rp 70.000.",
                'logistics_description' => "Jalur Bambangan termasuk jalur yang cukup ramah logistik di bagian awal karena terdapat banyak warung makan di sepanjang perjalanan bawah. Hal ini sangat menguntungkan karena pendaki tidak perlu mengonsumsi atau membawa bekal makanan berat terlalu banyak sejak awal. Namun, pendaki tetap diwajibkan mematuhi aturan pelestarian lingkungan seperti dilarang memetik bunga edelweis, membuat api unggun, atau meninggalkan sampah.",
            ]
            );
         $waypoints = [
            [
                'name' => 'Pos 1 Pondok Gembirung',
                'altitude' => 1937,
                'distance_from_prev' => 2, // km 
                'estimated_time_minutes' => 120, 
                'description' => 'Pendakian awal ini menyuguhkan pemandangan perkebunan sayur milik warga lokal di sisi kanan dan kiri jalur. Berbagai tanaman seperti kol, muncang, bayam, hingga stroberi akan menemani perjalanan sebelum memasuki batas hutan. Rute ini perlahan akan semakin menanjak dan curam seiring berakhirnya jalan desa.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Pondok Walang',
                'altitude' => 2256,
                'distance_from_prev' => 0.75, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Setelah melewati pos 1, trek tanah berubah menjadi semakin curam. Pendaki mulai memasuki area tutupan hutan gunung yang rapat dan rimbun, meninggalkan hawa panas area perkebunan warga.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Pondok Cemara',
                'altitude' => 2510,
                'distance_from_prev' => 0.7, // km 
                'estimated_time_minutes' => 70, 
                'description' => 'Di area ini, kondisi jalur pendakian Slamet akan bertemu dan menyatu dengan jalur pendakian via Pemalang. Hutan lumut yang asri mulai mendominasi bentang alam di sekitar jalur setapak ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Samarantu',
                'altitude' => 2688,
                'distance_from_prev' => 0.6,
                'estimated_time_minutes' => 60,
                'description' => 'Pos ini cukup legendaris di kalangan pendaki karena lekat dengan kisah mistis. Nama Samarantu konon merupakan singkatan dari "samar dan hantu", sehingga banyak pantangan yang beredar, salah satunya anjuran untuk tidak mendirikan tenda atau berhenti terlalu lama di pos ini. Secara fisik, jalurnya tertutup vegetasi lebat, sangat lembap, licin, dan dipenuhi oleh akar-akar pohon yang menyembul.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Samyang Rangkah',
                'altitude' => 2792,
                'distance_from_prev' => 0.325,
                'estimated_time_minutes' => 30,
                'description' => 'Pos 5 adalah lokasi paling direkomendasikan untuk membuka camp atau mendirikan tenda sebelum melakukan pendakian menuju puncak (summit attack). Lahan di area ini terbilang cukup luas untuk menampung banyak tenda, dan yang paling penting, terdapat sumber mata air yang bisa dimanfaatkan oleh pendaki.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 6 Samyang Ketebonan',
                'altitude' => 2909,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 45,
                'description' => 'Pos: Inilah lokasi camping ground bintang lima di jalur Cetho. Berjalan melintasi sabana landai, pendaki akan disuguhkan pemandangan luar biasa indah. Sesuai namanya, gupak berarti kubangan, tempat rusa (menjangan) dan babi hutan sering turun untuk minum. Area ini sangat luas, terlindung dari badai oleh perbukitan, dan menjadi titik paling ideal untuk tidur sebelum muncak.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 7 Samyang Kendit',
                'altitude' => 2990,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 60,
                'description' => 'Saat melintasi jalur ini menuju pos 7, kerapatan pohon mulai berkurang dan pendaki perlahan menyadari bahwa batas vegetasi hutan akan segera berakhir.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 8 Samyang Jampang',
                'altitude' => 3142,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 45,
                'description' => 'Sebuah fenomena unik terjadi di sini; terdapat "perkampungan" warung di atas awan, salah satunya Warung Mbok Yem yang legendaris. Area ini adalah titik kumpul para pendaki dari berbagai jalur (Cetho, Cemoro Sewu, Cemoro Kandang). Di dekatnya juga terdapat petilasan yang dikeramatkan, sehingga pendaki dilarang keras berbuat tidak sopan atau membuang sampah sembarangan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 9 Plawangan',
                'altitude' => 3150,
                'distance_from_prev' => 0.1,
                'estimated_time_minutes' => 30,
                'description' => ' Plawangan (pintu) adalah titik di mana vegetasi benar-benar telah berstatus terbuka seutuhnya. Tanjakan tajam berupa tanah tebal mendominasi medan, dan angin gunung yang bertiup bebas bisa menyebabkan suhu merosot tajam, membuat tubuh sangat mudah menggigil.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Gunung Slamet',
                'altitude' => 3428,
                'distance_from_prev' => 500,
                'estimated_time_minutes' => 120,
                'description' => ' "summit attack" ini merupakan ujian terberat menuju Atap Jawa Tengah, di mana trek sepenuhnya diisi oleh batu-batuan, pasir, dan kerikil labil. Disarankan pendaki menyebar di beberapa alur jalur yang berbeda saat berjalan untuk meminimalkan risiko terkena longsoran atau jatuhan batuan dari pendaki yang berada di atas. Namun, setelah melewati rute ekstrem tersebut, hamparan kawah luas dan awan tebal di puncak Slamet menjadi bayaran tuntas atas segala lelah.',
                'has_water_source' => false,
            ],
        ];
        foreach ($waypoints as $index => $wp) {
            $bambangan->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 2. VIA PERMADI GUCI
        $permadi = Route::firstOrCreate(
            ['mountain_id' => $slamet->id, 'name' => 'Gunung Slamet via Permadi Guci'],
            [
                'distance' => 8.4,
                'estimated_time' => 540, // 9 jam
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.213233,
                'longitude' => 109.171802 
            ]
        );

        $permadi->routeInfo()->updateOrCreate(['route_id' => $permadi->id],
            [
                'basecamp_address' => 'Kompleks Objek Wisata Pemandian Air Panas Guci, Desa Guci, Kecamatan Bumijawa, Kabupaten Tegal.',
                'basecamp_altitude' => 1219,
                'simaksi_price' => 35000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Pos 1 (Rp 25.000 - Rp 50.000).',
                'facilities_description' => "Basecamp Permadi Guci menawarkan keistimewaan letaknya yang berada tepat di kawasan wisata pemandian air panas Guci. Lokasi ini sangat ideal bagi pendaki yang ingin melakukan relaksasi atau pemulihan otot sebelum maupun sesudah pendakian yang panjang. Pendaki yang membawa rombongan juga dapat menyewa jasa guide lokal dengan tarif sekitar Rp 900.000 hingga Rp 1.000.000 per trip, atau menyewa porter dengan biaya antara Rp 850.000 hingga Rp 900.000. Tersedia juga fasilitas ojek lokal yang siap mengantar pendaki dari basecamp menuju Pos 1 (titik awal pendakian sebenarnya) untuk menghemat waktu dan tenaga, dengan tarif Rp 50.000.",
                'logistics_description' => "Jalur Permadi Guci merupakan salah satu rute paling istimewa dan direkomendasikan di Gunung Slamet karena ketersediaan fasilitas yang tidak biasa ditemukan di alam liar. Pendaki dapat menemukan mata air alami di sepanjang perjalanan bawah, dan area perkemahan utamanya bahkan difasilitasi dengan air bersih, MCK, hingga musala. Secara umum, jalur ini dikategorikan aman bagi pendaki pemula karena rutenya tergolong landai di beberapa pos awal dan jauh dari keramaian jalur populer lainnya.",
            ]
        );

        $waypointsPermadi = [
            [
                'name' => 'Pos 1 Blakbak',
                'altitude' => 1680,
                'distance_from_prev' => 3.5, 
                'estimated_time_minutes' => 120, 
                'description' => 'Rute menuju Pos 1 Blakbak menjadi fase pemanasan yang ideal. Pendaki akan dimanjakan dengan pemandangan lembah yang hijau, hamparan padang rumput yang luas, serta hutan yang asri. Udara segar pegunungan sangat terasa menyegarkan tubuh, dan treknya terbilang sangat aman karena mayoritas lintasannya cukup landai dan tidak dipenuhi tanjakan terjal yang menguras fisik.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Rimpakan',
                'altitude' => 2011,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 105, 
                'description' => 'Selepas dari Pos 1, medan mulai berubah menantang seiring masuknya pendaki lebih dalam ke area tutupan hutan Gunung Slamet. Jalur diapit oleh pepohonan rapat, namun tingkat kesulitan medannya masih cukup bisa ditoleransi oleh pendaki pemula tanpa memerlukan keahlian teknis khusus.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Selo Pethak',
                'altitude' => 2369,
                'distance_from_prev' => 1.4, 
                'estimated_time_minutes' => 75, 
                'description' => 'Rute tanah menuju Selo Pethak masih berada di kawasan hutan belantara yang rimbun. Pendaki harus tetap menjaga ritme berjalan untuk menyeimbangkan stamina, mengingat jalan setapak ini mulai terus-menerus memberikan elevasi secara konsisten sebelum tiba di area perkemahan utama.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Ranu Amreta',
                'altitude' => 2438,
                'distance_from_prev' => 1.5,
                'estimated_time_minutes' => 50,
                'description' => 'Pos 4 adalah area camping ground paling sentral dan populer di jalur Permadi Guci. Lahan kemahnya didesain sedemikian rupa dengan fasilitas pendukung luar biasa yang jarang ditemui di atas gunung, yakni instalasi air bersih yang mengalir, musala untuk beribadah, hingga fasilitas MCK. Hampir semua pendaki memilih mendirikan tenda dan beristirahat total di titik ini sebelum melakukan serangan puncak di keesokan harinya.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 5 Watu Ireng / Pondok Cantigi / Plawangan',
                'altitude' => 2868,
                'distance_from_prev' => 2.0, 
                'estimated_time_minutes' => 120,
                'description' => 'Setibanya di Pos 5 Watu Ireng yang juga dikenal dengan sebutan Plawangan atau Pondok Cantigi, jalur akan didominasi oleh banyak tanjakan ekstrem tanpa peneduh alami. Tempat ini sering kali dimanfaatkan sebagai area kemah alternatif terakhir bagi mereka yang ingin memangkas durasi muncak, dengan jarak tersisa sekitar 2 hingga 3 kilometer menuju Puncak Slamet.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Salam Permadi & Puncak Surono',
                'altitude' => 3428,
                'distance_from_prev' => 1.3,
                'estimated_time_minutes' => 135,
                'description' => 'Pendakian akhir ini (summit attack) melintasi batuan vulkanik terbuka yang akan menguji seluruh fisik dan mental pendaki. Meski medan tanjakannya curam, letih akan langsung terbayar lunas ketika menyaksikan keindahan pemandangan golden sunrise dan lautan awan yang menakjubkan, ditambah latar belakang Gunung Merapi di kejauhan. Pendaki tetap wajib bersikap waspada dan mematuhi himbauan keamanan untuk tidak beraktivitas dalam radius 3 km dari kawah karena status gunung yang masih bisa sangat aktif.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsPermadi as $index => $wp) {
            $permadi->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 3. VIA GUNUNG MALANG
        $malang = Route::firstOrCreate(
            ['mountain_id' => $slamet->id, 'name' => 'Gunung Slamet via Gunung Malang'],
            [
                'distance' => 8.0,
                'estimated_time' => 540, // 9 jam
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.2811
            ]
        );

        $malang->routeInfo()->updateOrCreate(['route_id' => $malang->id],
            [
                'basecamp_address' => 'Dusun Gunung Malang, Desa Serang, Kecamatan Karangreja, Kabupaten Purbalingga, Jawa Tengah.',
                'basecamp_altitude' => 1768, 
                'simaksi_price' => 20000,
                'ojek_price' => null,
                'ojek_description' => 'Tidak ada akses ojek di jalur Gunung Malang.',
                'facilities_description' => "Basecamp Gunung Malang dikelola dengan baik dan menyediakan fasilitas yang memadai seperti warung, kamar mandi, tempat istirahat, serta area parkir yang luas. Biaya parkir kendaraan dipatok sekitar Rp 5.000 per malam untuk motor dan Rp 10.000 per malam untuk mobil. Jika pendaki tidak ingin membawa beban berat, tersedia jasa porter dengan tarif mulai dari Rp 400.000 hingga Rp 800.000. Hal yang membuat jalur ini unik adalah penerapan sistem konservasi ketat; pengunjung dibatasi hanya 100 orang per hari dan dilarang keras membawa sampah anorganik ke atas gunung.",
                'logistics_description' => "Mengusung konsep jalur konservasi, pendaki tidak akan menemukan bangunan shelter atau pondok pelindung permanen di tiap posnya. Manajemen logistik sangat penting di sini. Pihak basecamp mewajibkan setiap pendaki membawa perbekalan yang cukup, termasuk cadangan air mineral minimal 1,5 liter per orang dari titik terbawah. Meskipun minim fasilitas buatan, jalur ini memiliki ketersediaan mata air alami di area Pos 3 dan Pos 4. Karena jalur ini sangat sepi dan cuaca bisa berubah drastis, pendaki diwajibkan membawa headlamp, jas hujan, jaket windproof/waterproof, kotak P3K, dan baju ganti.",
            ]
        );

        $waypointsMalang = [
            [
                'name' => 'Pos 1 Wadas Gantung',
                'altitude' => 1768,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Lintasannya dimulai dengan menembus perkampungan dan area perkebunan warga dengan kontur yang berangsur-angsur menjadi terjal. Pos Wadas Gantung sendiri sangat ikonik dan kerap dijadikan tujuan akhir bagi pendaki yang hanya ingin berkemah ceria, karena menyuguhkan lanskap malam dan sunrise (semburat fajar) yang sangat spektakuler. Catatan Penting: Per April 2026, pihak pengelola sering membatasi batas pendakian hanya sampai Pos 1 ini karena adanya pembenahan jalur rusak atau hilang di pos-pos atasnya.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Pondok Syahang',
                'altitude' => 2000, // estimated
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Pendaki akan disambut oleh rimbunnya pepohonan yang masih sangat hijau dan asri. Trek dari Pos 1 ke Pos 2 ini masih tergolong ringan dan sangat direkomendasikan untuk membiasakan otot kaki. Karena jarangnya pendaki yang melintas, suasana jalurnya sangat hening, sangat bersih dari tumpukan sampah, dan sangat kental dengan nuansa petualangan liar.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Pondok Pasang',
                'altitude' => 2300, // estimated
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Setibanya di Pondok Pasang, bonus jalan landai resmi berakhir. Pos ini menjadi batas dimulainya trek tanjakan panjang, di mana jalur akan terus-menerus menanjak tanpa jeda hingga mencapai puncak administratif Gunung Malang di Pos 5.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Pondok Ihing / Mata Air',
                'altitude' => 2600, // estimated
                'distance_from_prev' => null,
                'estimated_time_minutes' => 60,
                'description' => 'Meski medannya terus menguras tenaga, pendaki bisa bernapas lega di area ini. Sesuai dengan namanya, di kawasan Pondok Ihing terdapat aliran mata air alami yang bisa dimanfaatkan untuk memulihkan perbekalan cairan rombongan sebelum melanjutkan pendakian curam ke atas.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 5 Puncak Gunung Malang',
                'altitude' => 2800, // estimated
                'distance_from_prev' => null,
                'estimated_time_minutes' => 45,
                'description' => 'Hal yang sangat mengecoh dari jalur ini adalah titik Pos 5 bukanlah Atap Jawa Tengah, melainkan "puncak" dari anak gunungnya (Gunung Malang). Karakteristik medannya sangat unik, karena setelah pendaki berhasil mendaki dengan susah payah sampai titik elevasi ini, jalur justru akan berubah drastis menjadi turunan (downhill) menuju area pertemuan pos selanjutnya.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 6 Pondok Tanganan',
                'altitude' => 2750, // downhill
                'distance_from_prev' => null,
                'estimated_time_minutes' => 10,
                'description' => 'Mengingat lokasinya yang terlindung, area Pos 6 sering dijadikan rekomendasi tempat paling ideal untuk membuka tenda (camp) dan bermalam. Ekosistem di sekitarnya sangat terjaga, sehingga tidak heran jika pendaki sering bersinggungan langsung dengan habitat hewan-hewan liar penghuni hutan Slamet.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 7 Plawangan',
                'altitude' => 3100, // estimated
                'distance_from_prev' => null,
                'estimated_time_minutes' => 60,
                'description' => 'Seperti halnya pos Plawangan di rute lain, titik ini berfungsi sebagai gerbang batas antara hutan rimba berpepohonan rimbun dengan alam liar yang sepenuhnya terbuka. Terpaan angin kencang akan mulai menyiksa fisik pendaki mulai dari titik ini hingga ke puncak.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Gunung Slamet',
                'altitude' => 3428,
                'distance_from_prev' => null,
                'estimated_time_minutes' => 120, // 2 jam
                'description' => 'Siksaan terakhir (summit attack) harus ditempuh di atas material pasir dan batu labil di mana paparan suhu dingin begitu ekstrem. Namun, jerih payah mendaki berjam-jam lewat jalur konservasi ini akan terbayar lunas begitu pendaki menjejakkan kaki di bibir kawah dan memandangi hamparan lautan awan dari puncak tertinggi di Jawa Tengah.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsMalang as $index => $wp) {
            $malang->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }
    }
}
