<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class SumbingSeeder extends Seeder
{
    public function run(): void
    {
        $sumbing = Mountain::firstOrCreate(
            ['name' => 'Gunung Sumbing'],
            [
                'location' => 'Kab. Wonosobo, Temanggung, Magelang, Jawa Tengah', 
                'altitude' => 3371,
                'description' => 'Gunung Sumbing merupakan gunung tertinggi kedua di Jawa Tengah yang kokoh berdiri melintasi perbatasan Wonosobo, Temanggung, dan Magelang. Dengan puncaknya yang berbatu dan kawahnya yang masih aktif berasap, Sumbing adalah primadona para pendaki yang menyukai tantangan dan trek ekstrem.',
                'latitude' => -7.3847,  
                'longitude' => 110.0706, 
            ]
        );

        // 1. VIA GARUNG
        $garung = Route::firstOrCreate(
            ['mountain_id' => $sumbing->id, 'name' => 'Gunung Sumbing via Garung'],
            [
                'distance' => 7.0, 
                'estimated_time' => 410, // 2h + 50m + 1h + 3h
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.3501, 
                'longitude' => 109.9910
            ]
        );

        $garung->routeInfo()->updateOrCreate(['route_id' => $garung->id],
            [
                'basecamp_address' => 'Jl. Raya Brengkok - Banjarnegara, Desa Garung, Kecamatan Kalikajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1400,
                'simaksi_price' => 25000,
                'ojek_price' => 30000,
                'ojek_description' => 'Basecamp – Pos 1 (Rp 30.000).',
                'facilities_description' => 'Basecamp Garung adalah rute legendaris dan tertua. Berada di pinggir jalan raya memudahkan akses moda bus maupun pribadi. Ojek lokal siap mengantar hemat waktu melewari makadam batu menuju batas Pos 1 (sekitar Rp 30.000).',
                'logistics_description' => 'Dikenal karena medannya sangat terjal di atas tanpa henti, trek "Pengkolan 9" legendaris sanggup menyiksa kaki siapapun. Kebutuhan air cukup terjamin dengan sumber terpasang melimpah dekat ojek dan di Pos 3 (area utama camping ground).',
            ]
        );

        $waypointsGarung = [
            [
                'name' => 'Pos 1 Malim',
                'altitude' => 1750,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 120, // jalan kaki
                'description' => 'Jalan makadam berbatu menanjak melintasi kebun warga. Disarankan ojek (15 menit tiba). Lahan tak bisa untuk tenda tapi ada pangkalan mata air untuk pengisian drigen sebelum masuk tajuk hutan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Baon',
                'altitude' => 2100,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 50, 
                'description' => 'Dinaungi pohon rimbun dan teduh, melintas tanah padat padu dan sela batu. Terkadang terdapat warung warga di sana membuka lapak peristirahatan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Sebogo',
                'altitude' => 2600,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 60, 
                'description' => 'Sukses menaklukkan tanjakan zig-zag bertingkat ekstrem "Pengkolan 9", pendaki dihadiahi camp utama yang luas, aman, ada saluran air segar hingga fasilitas MCK langka di atas gunung.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Kekawah',
                'altitude' => 3371,
                'distance_from_prev' => 2.5, 
                'estimated_time_minutes' => 180, 
                'description' => 'Summit attack brutal merayap pada batuan lepas rawan longsor. Langsung disambut bau belerang kental dari dasar kaldera yang merekah besar mendidih.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsGarung as $index => $wp) {
            $garung->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 2. VIA BANARAN
        $banaran = Route::firstOrCreate(
            ['mountain_id' => $sumbing->id, 'name' => 'Gunung Sumbing via Banaran'],
            [
                'distance' => 6.5, 
                'estimated_time' => 510, 
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.3590, 
                'longitude' => 110.1500
            ]
        );

        $banaran->routeInfo()->updateOrCreate(['route_id' => $banaran->id],
            [
                'basecamp_address' => 'Desa Banaran, Kecamatan Tembarak, Kabupaten Temanggung, Jawa Tengah.',
                'basecamp_altitude' => 1300,
                'simaksi_price' => 10000,
                'ojek_price' => 40000,
                'ojek_description' => 'Basecamp – Pos 0 (Rp 40.000).',
                'facilities_description' => 'Alternatif mendaki dari sisi timur / Temanggung. Tarif sangat terjangkau bersahabat. Dikelola rapi hingga melayani ojek sampai Pos 0 (1438 mdpl) membanderol Rp40.000.',
                'logistics_description' => 'Berkarakteristik undakan tanah yang diukir membentuk anak tangga tinggi. Mengkombinasi kemudahan logistik warung dan Mushola di trayek awal, ditutup sumber air murni di area Pos 4 Watu Ondho sebagai spot kemping andalan.',
            ]
        );

        $waypointsBanaran = [
            [
                'name' => 'Pos 1 Seklenteng',
                'altitude' => 1887,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 120, 
                'description' => 'Medannya seru dan unik dibentuk serupa tata letak tangga alami tanah. Dijumpai banyak warung gubuk pendukung nafas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Siwel-iwel',
                'altitude' => 2141,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 75, 
                'description' => 'Anak tangga ini kian vertikal ke dalam perut hutan sempit. Dilarang tenda karena area tidak layak dan melanggar rute.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Punthuk Barah',
                'altitude' => 2387,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 60, 
                'description' => 'Undakan tanah berakhir dan diganti lintasan khas akar rimba. Lahan datar sedikit tersedia bagi kelompok lelah merayap tak terburu ngecamp.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Watu Ondho',
                'altitude' => 2732,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 75, 
                'description' => 'Bintang 5 rute banaran. Terbuka sebagian rimbanya dan beralih bebatuan dominan. Titik kemah yang mengalirkan mata air 100 meter lokasinya.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Segara Banjaran',
                'altitude' => 3147,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 120, 
                'description' => 'Area terganas dalam pendakian. Lanjut disambut terbukanya karpet sabana maha luas menari melatari jurang kuning belerang Sumbing yang perkasa.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Rajawali',
                'altitude' => 3371,
                'distance_from_prev' => 0.5, 
                'estimated_time_minutes' => 60, 
                'description' => 'Tinggal sejengkal lagi menggapai bonggol batu tajam penanda tahta Rajawali dari sebelah barat Jawa Tengah. Surga samudra awan disuguhkan.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsBanaran as $index => $wp) {
            $banaran->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 3. VIA BOWONGSO
        $bowongso = Route::firstOrCreate(
            ['mountain_id' => $sumbing->id, 'name' => 'Gunung Sumbing via Bowongso'],
            [
                'distance' => 6.0, 
                'estimated_time' => 365, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.4205, 
                'longitude' => 110.0150
            ]
        );

        $bowongso->routeInfo()->updateOrCreate(['route_id' => $bowongso->id],
            [
                'basecamp_address' => 'Desa Bowongso, Kecamatan Kalikajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1400,
                'simaksi_price' => 25000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Parkiran Swadas / Pintu Rimba (Rp 25.000).',
                'facilities_description' => 'Memiliki layanan penawaran ojek swadas yang mengeliminasi perjalanan pejalan kaki 2 jam menjadi 15 menit saja menembus aspal (Rp25ribu). Basecamp ramah dan permai di perkampungan atas.',
                'logistics_description' => 'Rute padang ilalang yang tinggi menjulang, dengan kekurangan minimnya ketersediaan air murni dari bawah. Mengisi formasi wadah jerigen air di warung sebelum Pintu Rimba adalah hukumnya wajib.',
            ]
        );

        $waypointsBowongso = [
            [
                'name' => 'Gardu Pandang & Pos 1 Taman Asmara',
                'altitude' => 1920,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 40, 
                'description' => 'Pos singgah berisi kantin hangat lalu menelusur kanopi rindang. Sangat landai bahkan diselingi lajur bonus pemanasan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Bogel',
                'altitude' => 2030,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 90, 
                'description' => 'Ilalang sebatas dada mengerubungi punggung. Tanjakan mulai intensif menendang pernafasan. Cukup ruang untuk gelar tenda darurat.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Camp Gajahan',
                'altitude' => 2400,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 35, 
                'description' => 'Tempat pelarian mayoritas jiwa yang keletihan mendaki untuk menghimpun kemahnya, bermalam ceria menghadap indahnya padang bintang di atas Sumbing lereng barat.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Zoro',
                'altitude' => 2860,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 50, 
                'description' => 'Titik akhir "Last Camp", namun nyaris melukai raga akibat terjangan hawa minus belasan derajat dan hantaman badai menabrak batu tanpa ampun.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Bayangan & Puncak Rajawali',
                'altitude' => 3371,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 150, 
                'description' => 'Tanjakan ekstrem berbatu curam raksasa yakni "Tanjakan Siginjel". Harus memanjat webbing menembus Rajawali sebelum tergapai mahkotanya.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsBowongso as $index => $wp) {
            $bowongso->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 4. VIA KALIANGKRIK (NEPAL VAN JAVA)
        $kaliangkrik = Route::firstOrCreate(
            ['mountain_id' => $sumbing->id, 'name' => 'Gunung Sumbing via Kaliangkrik'],
            [
                'distance' => 7.0, 
                'estimated_time' => 405, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.4201, 
                'longitude' => 110.0551
            ]
        );

        $kaliangkrik->routeInfo()->updateOrCreate(['route_id' => $kaliangkrik->id],
            [
                'basecamp_address' => 'Desa Temanggung (Kawasan Wisata Nepal Van Java), Kecamatan Kaliangkrik, Kabupaten Magelang, Jawa Tengah.',
                'basecamp_altitude' => 1650,
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Pos 1 Kongsen (Rp 25.000).',
                'facilities_description' => 'Melewati gang desa pariwisata magelang yang estetik warni warni di cerukan curam lereng Sumbing (Nepal Van Java). Fasilitas dijamin komplit layaknya wisata swasta. Dilayani ojek menyusur beton rumah dengan 25rb.',
                'logistics_description' => 'Luar biasa subur mendapati keindahan hutan tropis, dengan iringan suara gemirincik sungai kecil pengairan pertanian yang leluasa mengisi suplai air murni hingga Pos 4.',
            ]
        );

        $waypointsKaliangkrik = [
            [
                'name' => 'Pos 1 Sirebut (Kongsen)',
                'altitude' => 2127,
                'distance_from_prev' => 1.3, 
                'estimated_time_minutes' => 60, 
                'description' => 'Beton perkebunan bertransformasi pada Pintu rimba Sumbing Magelang. Momen napas tercekat 1.3KM jika enggan menyewa ojek.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos Bayangan & Pos 2 Siruwet',
                'altitude' => 2400,
                'distance_from_prev' => 2.2, 
                'estimated_time_minutes' => 120, 
                'description' => 'Beringsut merayapi lembab lumut dan licin akar purba menjulang lebat di tengah hutan belantara tertutup kanopi tropis.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Adipuro',
                'altitude' => 2650,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 75, 
                'description' => 'Zona idaman membangun tenda perkemahan yang asri serta aman terlindung tebing angin. Didukung tepian arus air sungai kecil di tikungannya membasahi kerongkongan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Cepogo',
                'altitude' => 2983,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 90, 
                'description' => 'Sungai parit membelah rute dengan keindahan absolut menembus awan dan kehilangan pepohonan besar pelindung. Badai angin sangat riskan terjadi saat kemping mendadak di sini.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Sejati',
                'altitude' => 3371,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 60, 
                'description' => 'Serangan vertikal pada bidang kemiringan parah. Disisakan keharusan menarik raga memeluk tebing memanfaatkan utas tali pengelola agar melampaui puncak Sejati sang jawara Magelang.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsKaliangkrik as $index => $wp) {
            $kaliangkrik->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // 5. VIA BATURSARI (AZORA)
        $batursari = Route::firstOrCreate(
            ['mountain_id' => $sumbing->id, 'name' => 'Gunung Sumbing via Batursari (Azora)'],
            [
                'distance' => 8.0, 
                'estimated_time' => 360, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.3401, 
                'longitude' => 110.0201
            ]
        );

        $batursari->routeInfo()->updateOrCreate(['route_id' => $batursari->id],
            [
                'basecamp_address' => 'Jl. Raya Parakan - Wonosobo Km. 12, Desa Batur Sari, Kec. Kledung, Kab. Temanggung, Jawa Tengah.',
                'basecamp_altitude' => 1400,
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp – Pintu Rimba (Rp 25.000).',
                'facilities_description' => 'Sering disebut pintu masuk kembar dengan Sindoro Kledung di sebrang aspal provinsi. Ojek menarif 25 ribu menghambat siksaan beton hingga pucuk perladangan tembakau Kledung.',
                'logistics_description' => 'Layanan infrastruktur perkemahannya terbaik dari yang lain. Berkat instalasi peralon yang digelontorkan memanjang, keran air mengalir deras dan jernih pada pos kemping strategis rute sejuk ini.',
            ]
        );

        $waypointsBatursari = [
            [
                'name' => 'Pos 1 Siroto',
                'altitude' => 1700,
                'distance_from_prev' => 2.2, 
                'estimated_time_minutes' => 60, 
                'description' => 'Hutan Terong belanda melambai di gerbang rimba yang asri. Jalan yang teduh merajai Pos singgah berselimut hening pepohonan berlumut.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Bidoblang',
                'altitude' => 2245,
                'distance_from_prev' => 1.5, 
                'estimated_time_minutes' => 60, 
                'description' => 'Intensitas tanjakan menuntut napas namun terobati lewat ketersediaan pilar keran pralon bagi cuci-cuci dan hilangkan dahaga. Terdapat bangunan gubuk peristirahatan tertutup.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Petai Cina',
                'altitude' => 2600,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 60, 
                'description' => 'Kawasan camp utama seluas belasan tenda beralaskan Hutan Akasian (Kasiyah). Keran mengalir tumpah ruah untuk kebebasan logistik tanpa was was kekurangan bekal cairan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4',
                'altitude' => 3021,
                'distance_from_prev' => 1.2, 
                'estimated_time_minutes' => 90, 
                'description' => 'Mengawali jalur punggungan gersang miring di tepian Pos Sunset tebing indah. Batu batu mulai bergeronjal menghadangkan kerikil runcing ke wajah pendaki mendongak.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Watu Singa (Menuju Rajawali)',
                'altitude' => 3371,
                'distance_from_prev' => 1.0, 
                'estimated_time_minutes' => 90, 
                'description' => 'Melintas bebatuan yang ditumbuhi ukiran lahar singa menjulang kawah abadi ke langit timur meruahkan takdir bertemu rombongan rute lain demi berbaur merayakan sang Puncak Sumbing.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsBatursari as $index => $wp) {
            $batursari->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

    }
}
