<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class PrauSeeder extends Seeder
{
    public function run(): void
    {
        $prau = Mountain::firstOrCreate(
            ['name' => 'Gunung Prau'],
            [
                'location' => 'Kab. Wonosobo, Kendal, Batang, Temanggung, Jawa Tengah',
                'altitude' => 2590,
                'description' => 'Gunung Prau merupakan gunung dengan puncak berwujud padang sabana luas yang menjadi favorit pendaki di Jawa Tengah. Puncak Prau sangat terkenal akan pemandangan (golden sunrise) yang dilatari kemegahan siluet duo Gunung Sindoro dan Gunung Sumbing.',
                'latitude' => -7.1887,
                'longitude' => 109.9238,
            ]
        );

        // ==========================================
        // 1. VIA DIENG
        // ==========================================
        $dieng = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Dieng'],
            [
                'distance' => 4.5, 
                'estimated_time' => 135, // ~2.25 hours
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $dieng->routeInfo()->updateOrCreate(['route_id' => $dieng->id],
            [
                'basecamp_address' => 'Jl. Raya Wonosobo - Batur Km 26, Desa Dieng Wetan, Kecamatan Kejajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 2000,
                'simaksi_price' => 30000,
                'ojek_price' => null,
                'ojek_description' => 'Tidak ada ojek resmi untuk jalur ini karena titik mulai pendakian (start) sudah sangat dekat dengan lahan perladangan.',
                'facilities_description' => 'Jalur Dieng adalah rute paling klasik dan sangat bersahabat bagi pendaki pemula. Lokasinya berada tepat di kawasan wisata Dieng Plateu, sehingga basecamp ini memiliki fasilitas luar biasa lengkap (warung, penginapan sekitar, toilet, dan musala).',
                'logistics_description' => 'Rute Dieng sangat asri dengan kanopi hutan cemara yang rapat. Sayangnya, tidak ada sumber mata air alami di sepanjang lintasan gunung ini. Pendaki wajib membawa perbekalan air matang dan logistik dari basecamp secara penuh untuk kebutuhan camping maupun muncak.',
            ]
        );

        $waypointsDieng = [
            [
                'name' => 'Pos 1 Gemekan',
                'altitude' => 2150,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 20, 
                'description' => 'Rute pemanasan melintasi jalan makadam yang diapit hamparan ladang kentang milik warga lokal. Setibanya di Pos 1 Gemekan, pendaki akan menjumpai pintu gerbang rimba yang menandakan dimulainya area memasuki hutan lindung Gunung Prau.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Semendung',
                'altitude' => 2300,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Ini adalah jalur favorit para pemula. Kontur jalannya sangat bervariasi; walaupun menanjak, trek ini memberikan sangat banyak "bonus" berupa jalan mendatar. Hutan di area ini cukup rimbun dan sejuk, menjadikannya trek yang tidak menyiksa lutut.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Ranger (Ngencling)',
                'altitude' => 2450,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Hutan semakin rapat dan akar pohon sesekali menjadi pijakan alami. Pos ini berwujud area teduh yang menandakan batas sebelum vegetasi hutan benar-benar tertinggal dan berubah menjadi alam sabana terbuka.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Gunung Prau & Telaga Wurung',
                'altitude' => 2590,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Jalur terbuka yang memperlihatkan keindahan sabana Prau. Pendaki akan menyentuh titik elevasi tertinggi terlebih dahulu (2590 mdpl) atau Telaga Wurung. Area ini biasanya sangat berangin kencang, kemudian pendaki cukup berjalan menurun landai selama kurang lebih 30-40 menit menyusuri punggungan ke arah Sunrise Camp utama tempat tenda-tenda didirikan.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsDieng as $index => $wp) {
            $dieng->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 2. VIA PATAK BANTENG
        // ==========================================
        $patakBanteng = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Patak Banteng'],
            [
                'distance' => 3.5, 
                'estimated_time' => 130, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $patakBanteng->routeInfo()->updateOrCreate(['route_id' => $patakBanteng->id],
            [
                'basecamp_address' => 'Desa Patak Banteng, Kecamatan Kejajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 1900,
                'simaksi_price' => 30000,
                'ojek_price' => 20000,
                'ojek_description' => 'Basecamp — Pos 1 Sikut Dewo (Rp 20.000 - Rp 30.000).',
                'facilities_description' => 'Inilah legend route atau jalur teramai dan paling favorit se-Gunung Prau. Jarak trekking-nya terpendek, sangat cocok untuk pendaki dari luar kota atau Jakarta karena lokasinya ada di pinggir jalan raya utama Wonosobo-Dieng. Fasilitas basecamp tak terhitung lagi jumlahnya. Keistimewaan rute ini adalah hadirnya Jasa Ojek dari pangkalan basecamp menuju Pos 1 dengan tarif pasti yakni Rp 20.000 per orang, yang sangat efektif memangkas waktu tempuh.',
                'logistics_description' => 'Rute pendek ini menuntut fisik ekstra. Tidak ada satupun mata air di trek Patak Banteng. Pendaki harus memborong bekal air minum dan makanan siap saji yang banyak dijajakan di kawasan basecamp.',
            ]
        );

        $waypointsPatakBanteng = [
            [
                'name' => 'Pos 1 Sikut Dewo',
                'altitude' => 2100,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Melintasi permukiman rumah warga, lalu dilanjut dengan tatanan tangga beton yang membelah ladang pertanian terjal. Area Pos 1 memiliki area istirahat. Mengingat tanjakannya yang membuat lutut lemas di awal, menggunakan ojek sangat direkomendasikan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Canggal Walang',
                'altitude' => 2300,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Patak Banteng memamerkan taringnya. Dari Pos 1 ke Pos 2, elevasi langsung berubah curam ekstrem nyaris tanpa jalan mendatar sedikitpun. Tanah berundak bagai anak tangga buatan akan terus memaksa paha dan betis bekerja maksimal. Lahan pos sempit dan sering digunakan sekadar untuk mengatur napas.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Cacingan',
                'altitude' => 2450,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Medannya semakin tanpa ampun dan sangat menyiksa lutut. Saat musim kemarau, rute curam ini akan menebarkan debu tebal, namun jika hujan berubah menjadi seluncuran lumpur. Pohon-pohon mulai menipis pertanda batas vegetasi akan segera terbuka.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Plawangan & Sunrise Camp (Puncak Prau)',
                'altitude' => 2565,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 40, 
                'description' => 'Melewati Plawangan (pintu batas rimba), rute berlanjut menyusuri padang sabana luas hingga sampailah di Sunrise Camp Prau, kawasan camping ground terluas di mana deretan Gunung Sindoro dan Sumbing tampak sejajar lurus bagaikan piramida raksasa (Duo Sindoro-Sumbing). Ini adalah magnet utama pendakian Prau.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsPatakBanteng as $index => $wp) {
            $patakBanteng->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 3. VIA KALILEMBU
        // ==========================================
        $kalilembu = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Kalilembu'],
            [
                'distance' => 4.0, 
                'estimated_time' => 150, 
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $kalilembu->routeInfo()->updateOrCreate(['route_id' => $kalilembu->id],
            [
                'basecamp_address' => 'Dusun Kalilembu, Desa Dieng, Kecamatan Kejajar, Kabupaten Wonosobo, Jawa Tengah.',
                'basecamp_altitude' => 2000,
                'simaksi_price' => 30000,
                'ojek_price' => 20000,
                'ojek_description' => 'Basecamp — Pos 1 Lemah Tugel (Rp 15.000 - Rp 20.000).',
                'facilities_description' => 'Jalur ini berdampingan dengan Patak Banteng (hanya berjarak 1 Km) dan sering jadi alternatif pelarian jika kuota Patak Banteng atau Dieng habis. Menawarkan wisata religi ke makam Syeh Abdullah Selomanik. Fasilitas basecamp tertata amat rapi, meliputi aula lesehan untuk rombongan yang baru tiba, toilet terawat, musala, dan puluhan stasiun charger ponsel untuk pendaki.',
                'logistics_description' => 'Karakteristik perbekalan sama persis dengan Patak Banteng; murni tanpa sumber air. Jadi, pendaki dilarang melupakan air kemasan botolan saat berkemas di basecamp.',
            ]
        );

        $waypointsKalilembu = [
            [
                'name' => 'Pos 1 Lemah Tugel',
                'altitude' => 2150,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 40, 
                'description' => 'Rute dimulai melewati perkampungan aspal dan ladang kentang sejauh kurang lebih 30 menit, dilanjut masuk gerbang batas vegetasi. Menuju Pos Lemah Tugel, jalurnya berupa tanah liat yang relatif masih sangat landai dan nyaman untuk pemanasan otot.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Gardu Pandang',
                'altitude' => 2350,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 50, 
                'description' => 'Masuk hutan rapat. Setengah etape awal masih bersahabat dengan kontur landai, namun saat mendekati Pos 2 jalanan langsung menjadi curam. Akibat tertutup kanopi daun, trek tanah ini biasanya licin dan lembap bahkan saat kemarau sekalipun.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 (Pertigaan Pertemuan Jalur)',
                'altitude' => 2450,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Disambut dengan jalan datar terlebih dahulu, pendaki kemudian akan kembali dipaksa menghadapi tanjakan hingga akhirnya tiba di pertigaan bersejarah. Di Pos 3 inilah jalur Kalilembu \'pecah\' dan bertemu langsung dengan pendaki yang berasal dari jalur Dieng serta jalur Dwarawati.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Top Prau (Puncak 2590) & Sunrise Camp',
                'altitude' => 2590,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, // 30 mins to Top, 30 mins to Camp
                'description' => 'Karena sudah menyatu, rute selanjutnya terbilang ringan. Melewati tanjakan santai selama 25-30 menit, pendaki tiba di Titik Triangulasi Top Prau (2590 mdpl), sebelum akhirnya menyusuri punggungan padang rumput hingga ke area Sunrise Camp (2565 mdpl) untuk mendirikan tenda yang luas.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsKalilembu as $index => $wp) {
            $kalilembu->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 4. VIA DWARAWATI
        // ==========================================
        $dwarawati = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Dwarawati'],
            [
                'distance' => 4.5, 
                'estimated_time' => 145, 
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $dwarawati->routeInfo()->updateOrCreate(['route_id' => $dwarawati->id],
            [
                'basecamp_address' => 'Gang Dwarawati, Desa Dieng Kulon, Kecamatan Batur, Kabupaten Banjarnegara, Jawa Tengah.',
                'basecamp_altitude' => 2000,
                'simaksi_price' => 30000,
                'ojek_price' => null,
                'ojek_description' => 'Tidak tersedia layanan ojek untuk jalur ini. Pendaki berjalan kaki melewati situs candi dan area pemukiman yang tenang langsung menuju jalur hutan.',
                'facilities_description' => 'Inilah jalur hidden gem di Gunung Prau. Sering dilabeli sebagai jalur "Sultan" atau "VIP" karena suasananya teramat sepi dari hiruk-pikuk pendaki, sangat menjaga privasi (konon sering dilewati pejabat/artis), dan letaknya tak jauh dari situs Candi Dwarawati. Terdapat aturan larangan keras membawa tisu basah dan alat musik. Jalur ini tidak menyediakan fasilitas jasa ojek sama sekali, sehingga rute terpanjang harus ditempuh murni dengan langkah kaki.',
                'logistics_description' => 'Sama seperti jalur Dieng, sama sekali tidak ada air yang bisa diisi di perjalanan. Persiapan matang dari area permukiman warga adalah kunci.',
            ]
        );

        $waypointsDwarawati = [
            [
                'name' => 'Pos 1 Yuyu Rumpung',
                'altitude' => 2189,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Tanpa kendaraan bermotor, pendaki diwajibkan trekking mengawali rute di antara perladangan dan setapak desa. Rute tanahnya masih sangat dominan landai dan tidak banyak membutuhkan tenaga ekstra untuk tiba di batas Pos 1 ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Pangonan Macan',
                'altitude' => 2280,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 40, 
                'description' => 'Pendaki mulai masuk melibas trek tangga tanah pegunungan yang menanjak. Di pos 2 inilah jalur Dwarawati perdana melakukan pertemuan simpang (merger) dengan rute yang datang dari Basecamp Dieng. Otomatis, jalur berangsur mulai terlihat ada aktivitas pendaki lain.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Nawang Sih',
                'altitude' => 2502,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Elevasi berubah dari kemiringan sedang menuju curam. Pendaki menembus lintasan bernama "Akar Cinta", wujudnya berupa tanah bercampur jaringan akar pohon cemara yang lebat. Sekitar 10 meter sebelum pos ini, jalur Dwarawati kembali bertabrakan dengan pendaki dari jalur Kalilembu. Pos 3-nya sendiri menyajikan dataran luas dan teduh, lumayan asyik untuk rebahan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Sabana',
                'altitude' => 2590,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Pos batas hutan terlewati, bentang alam langsung bertransisi menjadi rute setapak di sela-sela padang sabana ilalang eksotis Gunung Prau. Kurang lebih setengah jam kemudian, kaki menapak di titik elevasi tertinggi, sebelum turun bergabung di Sunrise Camp yang luas.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsDwarawati as $index => $wp) {
            $dwarawati->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 5. VIA WATES
        // ==========================================
        $wates = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Wates'],
            [
                'distance' => 5.0, 
                'estimated_time' => 165, 
                'difficulty' => 'easy',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $wates->routeInfo()->updateOrCreate(['route_id' => $wates->id],
            [
                'basecamp_address' => 'Jl. Candiroto – Kejajar Km 11, Desa Wates, Kecamatan Wonoboyo, Kabupaten Temanggung, Jawa Tengah.',
                'basecamp_altitude' => 1800,
                'simaksi_price' => 25000, // Rp 15.000 + Fasilitas BC Rp 10.000
                'ojek_price' => 30000,
                'ojek_description' => 'Basecamp — Pos 1 Blumbang Kodok/Pintu Rimba (Rp 30.000).',
                'facilities_description' => 'Jalur Wates adalah "Surga" untuk pecinta alam dan sering diserbu penggiat Solo Hiking. Kemiringan medannya bersahabat, jumlah pendakinya terbilang sedikit. Nilai jual basecamp ini adalah tersedianya Jasa Ojek warga (Tarif Rp 30.000) yang ampuh memangkas satu jam trekking desa langsung melompat ke batas hutan Pos 1.',
                'logistics_description' => 'Berbeda 180 derajat dari jalur Wonosobo, Wates adalah jalur "Basah". Jalur asri Temanggung ini diberkahi ekosistem utuh di mana terdapat sumber mata air segar di sekitar Pos 3, sehingga logistik di carrier bisa sangat diefisiensikan!',
            ]
        );

        $waypointsWates = [
            [
                'name' => 'Pos 1 Blumbang Kodok',
                'altitude' => 1900,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 60, 
                'description' => 'Rute jalan berlapis beton membelah perladangan. Sangat wajar jika pendaki naik ojek untuk melompati rute ini. Ujungnya, drop-off ojek berada di Pintu Rimba, gerbang awal memasuki hutan lebat Temanggung.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Cemaran',
                'altitude' => 2100,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 45, 
                'description' => 'Berbalut rapatnya pohon-pohon cemara yang dominan. Sepanjang jalurnya berwujud trek tanah dengan sudut tanjakan sedang/tidak terlalu curam. Perhatian Ekstra: Sesekali terdapat area semak belukar dan pepohonan dengan sarang/rumah lebah alam liar, jadi pastikan melangkah dengan tenang agar tidak mengundang serangan sengatan lebah!',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Sudung Dewo',
                'altitude' => 2300,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 30, 
                'description' => 'Ekosistem luar biasa asri. Pohon-pohon tinggi di sini dibalut oleh lumut hijau lembap. Setibanya di suatu persimpangan, belok ke arah kanan akan menuntun pendaki ke objek wisata air terjun, sedangkan jalur kiri menuju camp Pos 3 Sudung Dewo. Di sinilah letak ketersediaan air andalan di rute Wates dan bisa digunakan untuk mendirikan tenda sepi jika tak ingin ke atas.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Camp Pelawangan & Sunrise Camp (Via Rangkaian Bukit)',
                'altitude' => 2565,
                'distance_from_prev' => null, 
                'estimated_time_minutes' => 90, 
                'description' => 'Rute atas Wates ini sungguh estetik. Keluar dari rimba, pendaki disuguhkan tanah lapang bertingkat yang sambung-menyambung. Mulai dari Bukit Rindu, Camp Pelawangan, dan Cemoro Tunggal, kesemuanya adalah lahan camp alternatif bertabur sabana. Pendaki cukup memilih titik kumpul kemah paling akhir sebelum berjalan sebentar menuju mahkota tertinggi Gunung Prau.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsWates as $index => $wp) {
            $wates->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        // ==========================================
        // 6. VIA IGIRMANAK
        // ==========================================
        $igirmanak = Route::firstOrCreate(
            ['mountain_id' => $prau->id, 'name' => 'Gunung Prau via Igirmanak'],
            [
                'distance' => 4.3, 
                'estimated_time' => 220, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.2185, 
                'longitude' => 109.9077 
            ]
        );

        $igirmanak->routeInfo()->updateOrCreate(['route_id' => $igirmanak->id],
            [
                'basecamp_address' => 'Desa Igirmanak, Kecamatan Kejajar, Kabupaten Wonosobo, Jawa Tengah. (Titik masuk via Pertigaan Pasar Kejajar).',
                'basecamp_altitude' => 1745,
                'simaksi_price' => 30000,
                'ojek_price' => 25000,
                'ojek_description' => 'Basecamp — Pos 1 Curug Gamelan (Rp 20.000 - Rp 25.000).',
                'facilities_description' => 'Rute pendakian Igirmanak merupakan alternatif tersembunyi yang eksotis dari kawasan Kejajar Wonosobo. Jarak absolut trekking dari batas basecamp ke puncak totalnya memakan jarak vertikal 4,3 Kilometer (atau estimasi perjalanan normal 3 hingga 4 jam). Layaknya jalur Wonosobo lain, fasilitas pelengkap basecamp sudah memadai dari musala hingga tempat rehat. Pickup atau layanan ojek kadang disediakan warga untuk rute awal dari jalan aspal.',
                'logistics_description' => 'Berpotensi menjumpai titik air di rute bawah dekat kawasan air terjun/curug pos pertama, namun sangat dianjurkan menyuplai penuh jerigen dari warung/kamar mandi basecamp.',
            ]
        );

        $waypointsIgirmanak = [
            [
                'name' => 'Pos 1 Curug Gamelan',
                'altitude' => 2076,
                'distance_from_prev' => 1.6, 
                'estimated_time_minutes' => 90, 
                'description' => 'Jarak tempuh antara basecamp menuju Pos 1 adalah etape jalan kaki paling panjang di rute ini (lebih dari 1,5 Km). Membelah perladangan menuju lereng basah yang ditandai dengan keberadaan Curug (air terjun) Gamelan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Bukit Cendani',
                'altitude' => 2270,
                'distance_from_prev' => 0.68, 
                'estimated_time_minutes' => 60, 
                'description' => 'Melangkah keluar dari kawasan aliran curug, medan tanah mulai terjal menanjak ekstrem. Kawasan ini dinamakan Bukit Cendani karena vegetasi pegunungan khas, bambu-bambu kerdil serta pohon-pohon rimba tumbuh mendominasi menutup cahaya matahari langsung.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Roto Dowo',
                'altitude' => 2346,
                'distance_from_prev' => 0.53, 
                'estimated_time_minutes' => 40, 
                'description' => 'Jarak tempuh antar pos semakin mendekat. Elevasinya berubah cukup rapat, membawa pendaki tiba di Roto Dowo ("Daratan Rata yang Panjang"). Lahan ini mulai memberikan pemandangan transisi dari hutan lebat menjadi semak-semak pegunungan yang sedikit terbuka.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Camp Area Cemoro Tunggal & Sunrise Camp Prau',
                'altitude' => 2565,
                'distance_from_prev' => 1.3, 
                'estimated_time_minutes' => 60, 
                'description' => 'Rute sabana Prau sisi Igirmanak terbuka seutuhnya. Dari Pos 3, pendaki cukup mendaki punggungan pendek (375 m) menjumpai titik Camp Area Cemoro Tunggal. Jika masih memiliki sisa energi, sebagian besar akan berjalan melipir menyusuri padang rumput melengkung sejauh nyaris 1 kilometer menuju kawasan megah Sunrise Camp 2565 mdpl, bersiap membuka ritsleting tenda dengan sajian siluet Gunung Sindoro dan Sumbing.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypointsIgirmanak as $index => $wp) {
            $igirmanak->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

    }
}
