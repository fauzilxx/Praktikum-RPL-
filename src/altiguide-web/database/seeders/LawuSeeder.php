<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mountain;
use App\Models\Route;

class LawuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lawu = Mountain::firstOrCreate(
            ['name' => 'Gunung Lawu'],
            [
                'location' => 'Area Hutan, Gondosuli, Kec. Tawangmangu, Kabupaten Karanganyar, Jawa Tengah',
                'altitude' => 3265,
                'description' => 'Gunung Lawu adalah sebuah gunung berapi aktif yang terletak di Pulau Jawa, tepatnya di perbatasan Jawa Tengah dan Jawa Timur, Indonesia. Gunung Lawu memiliki ketinggian sekitar 3.265 mdpl. Gunung Lawu terletak di antara tiga kabupaten, yaitu Karanganyar di Jawa Tengah, Ngawi, dan Magetan di Jawa Timur.',
                'latitude' => -7.6275,
                'longitude' => 111.1941666,

            ]
            );
        $candiCetho = Route::firstOrCreate(
            ['mountain_id' => $lawu->id, 'name' => 'Gunung Lawu via Candi Cetho'],
            [
                'distance' => 9.5,
                'estimated_time' => 600, // 10 jam dalam menit
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.5949205,
                'longitude' => 111.1571055
            ]
            );
        $candiCetho->routeInfo()->updateOrCreate(['route_id' => $candiCetho->id],
            [
                'basecamp_address' => 'Dusun Cetho, Desa Gumeng, Kecamatan Jenawi, Kabupaten Karanganyar, Jawa Tengah',
                'basecamp_altitude' => 1140,
                'simaksi_price' => 20000,
                'facilities_description' => "Lokasi registrasi berada sangat dekat dengan kawasan wisata Candi Cetho. Di area sekitar basecamp, fasilitasnya sangat lengkap mulai dari warung makan, toilet, hingga penitipan kendaraan yang aman untuk menginap berhari-hari. Mengingat jalur ini searah dengan tempat wisata, akses jalannya sudah beraspal mulus namun memiliki tanjakan yang sangat curam, sehingga kendaraan bermotor yang dibawa harus dalam kondisi prima, terutama di bagian rem dan kopling.",
                'logistics_description' => "Jalur Cetho dikenal sebagai jalur spiritual dan wisata sekaligus. Dari segi perbekalan, pendaki sangat diuntungkan karena terdapat sumber mata air yang bisa diandalkan di Pos 3. Selain itu, pesona utama Lawu adalah keberadaan warung-warung di atas gunung, khususnya Warung Mbok Yem di area Hargo Dalem. Pendaki yang membawa uang tunai lebih bisa menghemat ruang di carrier karena bisa membeli nasi pecel, gorengan, teh hangat, hingga air mineral botolan di area mendekati puncak.",
            ]
            );
         $waypoints = [
            [
                'name' => 'Pos 1 Mbah Branti',
                'altitude' => 1702,
                'distance_from_prev' => 1.5, // km 
                'estimated_time_minutes' => 120, 
                'description' => 'Di awal pendakian, lintasan didominasi oleh tanah padat yang berdebu tebal saat musim kemarau dan sangat licin saat musim hujan. Pendaki akan melewati situs bersejarah Candi Kethek sebelum perlahan masuk ke kawasan hutan pinus dan ladang penduduk. Ritme menanjak di sini masih cukup ramah untuk pemanasan otot kaki dengan carrier berat.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Brakseng',
                'altitude' => 1914,
                'distance_from_prev' => 1, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Memasuki rute ini, vegetasi hutan lamtoro dan pinus mulai tergantikan oleh pepohonan rimba yang lebih besar dan rapat. Jalur tanah mulai diselingi oleh akar-akar pohon yang menonjol, dan elevasi tanjakan mulai konsisten menguras tenaga. Pos 2 memiliki area datar berupa tanah lapang beratap seng yang cukup untuk mendirikan 3-4 tenda jika terpaksa.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 CemoroDowo',
                'altitude' => 2251,
                'distance_from_prev' => 0.7, // km 
                'estimated_time_minutes' => 120, 
                'description' => 'Ini adalah titik logistik paling krusial. Terdapat sumber air berupa aliran dari pipa pralon yang jernih dan melimpah sepanjang tahun. Pendaki wajib mengisi penuh semua jerigen dan botol air di sini sebagai bekal untuk masak di area camp (Gupak Menjangan/Bulak Peperangan). Di pos ini juga sering terdapat warung warga dan fasilitas toilet sederhana.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Penggik',
                'altitude' => 2550,
                'distance_from_prev' => 1,
                'estimated_time_minutes' => 120,
                'description' => 'Trek dari Pos 3 ke Pos 4 terkenal sebagai *tanjakan penyiksaan* bagi pendaki yang membawa beban camp. Lintasannya sangat terjal, seolah tidak ada ujungnya, dan nyaris tidak memberikan bonus jalan datar. Jalurnya berupa tanah liat bercampur serasah daun yang sangat menguji mental dan kekuatan lutut.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Bulak Peperangan',
                'altitude' => 2861,
                'distance_from_prev' => 1.2,
                'estimated_time_minutes' => 120,
                'description' => 'Lelah menanjak ekstrem akhirnya terbayar lunas. Setelah menembus batas hutan yang gelap, bentang alam langsung terbuka menjadi hamparan sabana hijau keemasan yang sangat luas. Pos ini sering dijadikan alternatif area camp jika pos selanjutnya penuh. Konon, area ini dinamakan Bulak Peperangan karena dipercaya sebagai medan pertempuran pasukan Prabu Brawijaya V di masa lampau.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Gupak Menjangan',
                'altitude' => 2952,
                'distance_from_prev' => 0.8,
                'estimated_time_minutes' => 60,
                'description' => 'Pos: Inilah lokasi camping ground bintang lima di jalur Cetho. Berjalan melintasi sabana landai, pendaki akan disuguhkan pemandangan luar biasa indah. Sesuai namanya, gupak berarti kubangan, tempat rusa (menjangan) dan babi hutan sering turun untuk minum. Area ini sangat luas, terlindung dari badai oleh perbukitan, dan menjadi titik paling ideal untuk tidur sebelum muncak.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pasar Dieng',
                'altitude' => 3104,
                'distance_from_prev' => 1,
                'estimated_time_minutes' => 90,
                'description' => 'Memulai summit attack dari area camp, lintasan sabana rumput berubah wujud menjadi sabana bebatuan vulkanik yang berserakan namun tertata aneh. Area ini dipenuhi tumpukan batu yang dipercaya memiliki nilai mistis sebagai pasar gaib. Angin di kawasan ini berhembus sangat kencang dan suhu udara merosot tajam.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Hargo Dalem',
                'altitude' => 3142,
                'distance_from_prev' => 0.4,
                'estimated_time_minutes' => 45,
                'description' => 'Sebuah fenomena unik terjadi di sini; terdapat "perkampungan" warung di atas awan, salah satunya Warung Mbok Yem yang legendaris. Area ini adalah titik kumpul para pendaki dari berbagai jalur (Cetho, Cemoro Sewu, Cemoro Kandang). Di dekatnya juga terdapat petilasan yang dikeramatkan, sehingga pendaki dilarang keras berbuat tidak sopan atau membuang sampah sembarangan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Hargo Dumillah',
                'altitude' => 3265,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 60,
                'description' => 'Rute pamungkas ini berupa tanjakan curam yang menembus sela-sela batu padas dan semak cantigi. Sesampainya di puncak tertinggi Gunung Lawu, pendaki akan disambut oleh Tugu Hargo Dumilah yang ikonik. Dari sini, lanskap lautan awan yang magis tersaji 360 derajat, membayar tuntas belasan jam perjalanan berbeban berat dari Candi Cetho.',
                'has_water_source' => false,
            ],
        ];
        
        foreach ($waypoints as $index => $wp) {
            $candiCetho->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        $cemoroKandang = Route::firstOrCreate(
            ['mountain_id' => $lawu->id, 'name' => 'Gunung Lawu via Cemoro Kandang'],
            [
                'distance' => 9.7,
                'estimated_time' => 480, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.659647402366767,
                'longitude' =>  111.18669651322048
            ]
            );
        $cemoroKandang->routeInfo()->updateOrCreate(['route_id' => $cemoroKandang->id],
            [
                'basecamp_address' => 'Desa Gondosuli, Kecamatan Tawangmangu, Kabupaten Karanganyar, Jawa Tengah',
                'basecamp_altitude' => 1830,
                'simaksi_price' => 20000,
                'facilities_description' => 'Lokasi basecamp ini sangat strategis karena persis di pinggir jalan raya tembus Karanganyar-Magetan, berjarak sekitar 500 meter saja dari basecamp Cemoro Sewu. Fasilitasnya sangat memadai; ada masjid besar, toilet, area istirahat beralaskan karpet untuk pendaki, hingga pos penjagaan. Di sekitar area ini juga banyak warung makan dan kafe kekinian, jadi aman buat mencari sarapan sebelum mulai trekking.',
                'logistics_description' => 'Mirip dengan jalur Cetho, nilai plus mendaki Gunung Lawu adalah keberadaan warung pecel legendaris Mbok Yem di area Hargo Dalem dekat puncak. Kalau bawa uang tunai, beban logistik makanan di dalam carrier bisa dipangkas drastis. Untuk air bersih, jalur Cemoro Kandang punya beberapa titik mata air musiman di sekitar pos, salah satunya Sendang Panguripan. Tapi tetap disarankan bawa stok air minum yang aman dari bawah.',
            ]
            );
         $waypoints = [
            [
                'name' => 'Pos 1 Taman Sari Bawah',
                'altitude' => 2237,
                'distance_from_prev' => null , // km 
                'estimated_time_minutes' => 90 ,
                'description' => 'Ritme pendakian dari basecamp ke Pos 1 ini sangat bersahabat buat pemanasan. Lintasannya berupa tanah padat merah yang menembus hutan pinus lebat. Jalurnya cenderung landai dan terus memutar mengitari punggungan bukit, makanya jarak tempuhnya terasa cukup panjang meskipun secara tenaga tidak terlalu menguras fisik.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Taman Sari Atas',
                'altitude' => 2470,
                'distance_from_prev' => null, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Memasuki rute ini, vegetasi hutan berubah makin rapat. Tanjakan mulai terasa meski tetap diwarnai banyak jalan mendatar (bonus). Pos 2 ditandai dengan bangunan pelindung berupa pondok kayu dan atap seng. Kadang saat musim ramai pendakian, ada warga lokal yang buka warung kecil di sekitar area pos ini.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Penggik / Ompak-ompakan',
                'altitude' => 2700,
                'distance_from_prev' => null, // km 
                'estimated_time_minutes' => 120, 
                'description' => 'Jalur menuju Pos 3 mulai terasa menguji kesabaran. Lintasannya terus meliuk-liuk (zigzag) khas Cemoro Kandang dengan tanjakan yang makin sering. Vegetasi pohon besar mulai agak berkurang dan tergantikan oleh semak belukar. Area pos ini lumayan luas dan sering dipakai untuk camp darurat kalau hari sudah keburu gelap.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 4 Cokro Suryo / Ondho Rante',
                'altitude' => 3000,
                'distance_from_prev' => null,
                'estimated_time_minutes' => 90,
                'description' => ' Rute dari Pos 3 ke Pos 4 bisa dibilang sebagai etape paling berat di Cemoro Kandang. Pendaki akan bertemu dengan trek yang dinamakan Ondho Rante (tanjakan berantai) karena elevasinya yang curam dan rapat. Batas vegetasi pohon rimba resmi berakhir di sini, sehingga hawa dingin dan embusan angin gunung bakal langsung terasa menembus jaket.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Cokro Buwono',
                'altitude' => 3150,
                'distance_from_prev' => null,
                'estimated_time_minutes' => 45,
                'description' => 'Menembus area padang sabana yang ditumbuhi edelweis, jalurnya makin terbuka dengan alas batuan kerikil dan tanah keras. Area di sekitar sini sangat rawan badai angin. Pos 5 adalah lokasi bertemunya banyak pendaki dari jalur ini sebelum berjalan miring (melipir) ke arah pusat keramaian di Hargo Dalem.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Hargo Dalem',
                'altitude' => 3142,
                'distance_from_prev' => null ,
                'estimated_time_minutes' => 15,
                'description' => 'Hargo Dalem adalah "pusat kehidupan" Gunung Lawu. Di sinilah letak Warung Mbok Yem dan beberapa warung lain. Pendaki dari Cemoro Sewu dan Cemoro Kandang pasti akan memusatkan camp dan tempat istirahatnya di sekitar lembah ini. Area ini cukup terlindung dari angin karena berada di lekukan perbukitan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Hargo Dumillah',
                'altitude' => 3265,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 45,
                'description' => 'Berangkat dari Hargo Dalem, pendaki tinggal menghadapi satu tanjakan pamungkas. Medannya didominasi batu-batu padas dan debu. Puncak Gunung Lawu ditandai dengan Tugu Hargo Dumilah dan hamparan tanah datar yang sangat luas. Di sini, pemandangan ke arah Telaga Sarangan dan lanskap Jawa Tengah-Jawa Timur bakal kelihatan jelas kalau cuaca lagi cerah.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypoints as $index => $wp) {
            $cemoroKandang->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

         $cemoroSewu = Route::firstOrCreate(
            ['mountain_id' => $lawu->id, 'name' => 'Gunung Lawu via Cemoro Sewu'],
            [
                'distance' => 7,
                'estimated_time' => 300, 
                'difficulty' => 'moderate',
                'is_active' => true,
                'latitude' => -7.663454736206656,
                'longitude' =>  111.19143967601048
            ]
            );
        $cemoroSewu->routeInfo()->updateOrCreate(['route_id' => $cemoroSewu->id],
            [
                'basecamp_address' => 'Desa Ngancar, Kecamatan Plaosan, Kabupaten Magetan, Jawa Timur',
                'basecamp_altitude' => 1820,
                'simaksi_price' => 20000,
                'facilities_description' => 'Gerbang pendakian Cemoro Sewu memiliki aksesibilitas yang sangat mudah karena lokasinya tepat berada di tepi jalan raya aspal provinsi yang menghubungkan Kabupaten Karanganyar dan Magetan. Kawasan basecamp ini dikelola dengan sangat profesional dan terintegrasi. Fasilitasnya sangat komprehensif; meliputi area parkir paving yang luas dan mampu menampung puluhan mobil serta motor, masjid besar untuk beribadah, deretan kamar mandi dan toilet yang jumlahnya banyak serta ketersediaan air bersih yang melimpah. Di sekitar area pendaftaran, terdapat puluhan warung makan yang buka 24 jam, menjajakan menu seperti nasi pecel, soto hangat, gorengan, dan aneka minuman. Sistem pendaftaran di sini menerapkan SOP yang ketat; petugas akan mengecek kelengkapan alat keselamatan standar (tenda, kantong tidur, matras, jaket tebal) dan secara tegas melarang pendaki yang menggunakan celana jeans atau berbahan denim demi mencegah risiko hipotermia.',
                'logistics_description' => 'Rute Cemoro Sewu dikenal sebagai jalur pendakian dengan fasilitas logistik paling "mewah" di Pulau Jawa. Pada musim pendakian atau akhir pekan, dari pintu rimba hingga area puncak, pendaki akan banyak menjumpai warung-warung dadakan milik warga lokal yang menjual buah semangka potong, gorengan, hingga air mineral. Keberadaan warung-warung ini sangat krusial karena memungkinkan pendaki memangkas bobot logistik di dalam carrier. Pendaki cukup membawa uang tunai pecahan kecil yang cukup banyak. Untuk ketersediaan air alami, jalur ini memiliki dua sumber air utama, yakni mata air Sendang Panguripan yang terletak di antara basecamp dan Pos 1, serta Sendang Drajat yang berada persis di Pos 5.',
            ]
            );
            
         $waypoints = [
            [
                'name' => 'Pos 1 Wes-wesan',
                'altitude' => 2120,
                'distance_from_prev' => 1.5 , // km 
                'estimated_time_minutes' => 75 ,
                'description' => ' Melewati gapura Pintu Rimba, pendaki langsung disambut oleh lintasan khas Cemoro Sewu, yaitu jalanan berbatu (makadam) yang tersusun sangat rapi menyerupai anak tangga. Kanan dan kiri jalur diapit oleh tegakan pohon cemara gunung dan pinus yang sangat rapat, membuat suasana terasa teduh, sejuk, namun cukup lembap karena sinar matahari terhalang kanopi daun. Tanjakan mulai terasa konstan tanpa banyak jalan mendatar, memaksa otot paha dan betis beradaptasi dengan ritme melangkah naik. Pos 1 ditandai dengan sebuah pondok shelter beratap seng permanen yang cukup luas untuk beristirahat menghindari hujan.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 2 Watu Kethek',
                'altitude' => 2250,
                'distance_from_prev' => 1.2, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Penamaan "Watu Kethek" (Batu Monyet) merujuk pada keberadaan formasi batu-batu berukuran besar di sekitar area ini, dan di waktu-waktu tertentu kawanan kera ekor panjang liar masih sering melintas atau menampakkan diri di dahan pepohonan. Trek menuju Pos 2 menjadi semakin curam, tatanan batu kali yang menjadi pijakan terasa makin tinggi sehingga rentang langkah kaki harus lebih dilebarkan. Kerapatan pohon di area ini masih sangat pekat, sehingga jika mendaki pada sore menjelang malam, area ini akan terasa lebih cepat gelap.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 3 Watu Lumbung',
                'altitude' => 2750,
                'distance_from_prev' => 1, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Vegetasi tumbuhan mulai mengalami transisi; pepohonan berbatang besar mulai merenggang, digantikan oleh pohon-pohon cantigi dan semak belukar pegunungan. Elevasi tanjakan tangga batu di sini sangat menyiksa dan menguras stamina, nyaris tidak memberikan ruang atau jalan datar untuk menghela napas. Pos 3 memiliki ciri fisik berupa celah sempit yang terjepit di antara himpitan batu-batu vulkanik raksasa yang bentuknya menyerupai lumbung padi tradisional. Area ini sangat tidak disarankan untuk mendirikan tenda karena areanya yang sempit dan rawan terkena pusaran angin gunung.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Watu Kapur',
                'altitude' => 3020,
                'distance_from_prev' => 1.5,
                'estimated_time_minutes' => 100,
                'description' => 'Rute dari Pos 3 menuju Pos 4 adalah ujian fisik dan mental paling berat di jalur Cemoro Sewu. Pendaki akan melintasi anak tangga bebatuan padas yang meliuk-liuk ekstrem tepat di bibir jurang terbuka. Karena batas vegetasi pelindung sudah benar-benar tertinggal di bawah, tubuh akan langsung dihantam oleh embusan angin kencang yang sangat dingin. Namun, dari titik terbuka inilah lanskap Kabupaten Magetan, hamparan hutan, dan Telaga Sarangan terlihat sangat memukau jika cuaca sedang cerah. Pos 4 merupakan area terbuka yang hanya menyisakan reruntuhan fondasi bekas pos lama, sehingga pendaki dilarang berhenti terlalu lama di sini agar tidak terkena hipotermia.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Sendang Drajat',
                'altitude' => 3170,
                'distance_from_prev' => 0.6,
                'estimated_time_minutes' => 45,
                'description' => 'Rasa lelah akibat tanjakan ekstrem seketika terbayar saat pendaki tiba di cekungan lembah sabana yang sangat luas ini. Area Pos 5 dikelilingi oleh perbukitan yang berfungsi sebagai tameng alami pelindung dari badai angin. Di sini terdapat "Sendang Drajat", sebuah sumur alami berupa ceruk batu yang airnya tidak pernah kering dan diyakini memiliki nilai spiritual, namun sangat aman untuk digunakan memasak dan minum. Terdapat bangunan warung permanen yang beroperasi di pos ini. Lahan datarnya mampu menampung puluhan tenda, menjadikannya lokasi camping ground paling ideal dan ramai di jalur Cemoro Sewu sebelum melakukan pendakian akhir ke puncak.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Hargo Dalem',
                'altitude' => 3142,
                'distance_from_prev' => 0.3 ,
                'estimated_time_minutes' => 15,
                'description' => 'Lintasannya berupa jalan tanah datar berbatu yang melipir (kontur memutar) di tepian bukit. Hargo Dalem adalah pusat peradaban di atas Gunung Lawu. Kawasan ini merupakan titik temu bagi pendaki dari jalur Cemoro Sewu, Cemoro Kandang, dan Candi Cetho. Terdapat kompleks warung makan tertinggi di Indonesia, yang paling terkenal adalah Warung Mbok Yem. Banyak pendaki yang memilih untuk tidak mendirikan tenda dan menyewa tempat tidur di dalam warung-warung ini untuk menghangatkan diri di dekat tungku perapian sambil menikmati nasi pecel. Di area ini juga tersebar beberapa petilasan sakral peninggalan Prabu Brawijaya V, sehingga pendaki sering mencium aroma dupa dan diwajibkan menjaga kesopanan tutur kata.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Puncak Hargo Dumillah',
                'altitude' => 3265,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 45,
                'description' => 'Fase summit attack menuju titik tertinggi Gunung Lawu ini relatif singkat namun menuntut kehati-hatian. Medannya didominasi oleh tanjakan tanah padas berdebu tebal dan pecahan batu kapur yang mudah merosot saat dipijak, berselingan dengan rimbunan semak cantigi. Tiba di puncak, pendaki akan melihat monumen Tugu Hargo Dumilah yang berdiri kokoh di tengah hamparan tanah datar yang sangat lapang. Area ini sebagian ditumbuhi oleh bunga edelweis. Dari ketinggian ini, tersaji panorama 360 derajat yang luar biasa, di mana pada pagi hari yang jernih, jajaran Gunung Merapi, Merbabu, Sindoro, dan Sumbing akan terlihat berbaris rapi membelah lautan awan di ufuk barat.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypoints as $index => $wp) {
            $cemoroSewu->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }

        $singolangu = Route::firstOrCreate(
            ['mountain_id' => $lawu->id, 'name' => 'Gunung Lawu via Singolangu'],
            [
                'distance' => 9,
                'estimated_time' => 560, 
                'difficulty' => 'hard',
                'is_active' => true,
                'latitude' => -7.66028401876209, 
                'longitude' => 111.22763803494152
            ]
            );
        $singolangu->routeInfo()->updateOrCreate(['route_id' => $singolangu->id],
            [
                'basecamp_address' => 'Dusun Singolangu, Kelurahan Sarangan, Kecamatan Plaosan, Kabupaten Magetan, Jawa Timur.',
                'basecamp_altitude' => 1314,
                'simaksi_price' => 20000,
                'facilities_description' => 'Lokasi basecamp Singolangu sangat dekat dengan kawasan wisata Telaga Sarangan (berjarak sekitar 1 km). Fasilitas di basecamp cukup memadai, dengan area parkir kendaraan, toilet, musala, dan warung-warung kecil untuk melengkapi logistik sebelum mendaki. Hal yang paling membedakan jalur ini dari yang lain adalah aturan pembatasan waktu; pihak pengelola sangat ketat melarang pendakian pada malam hari (batas maksimal mulai mendaki pukul 17.00 WIB) karena jalur hutannya masih berupa "hutan perawan" yang sangat lebat dan rawan membuat pendaki tersesat jika dalam kondisi gelap.',
                'logistics_description' => ' Karena melewati rute spiritual yang tertua, kelestarian alam di Singolangu sangat terjaga. Pendaki akan dimanjakan dengan ketersediaan air yang sangat segar. Terdapat mata air Sendang Sanggar di awal pendakian, serta sumber air andalan di Pos 2 (Banyu Urip). Meskipun begitu, sangat disarankan untuk membawa persediaan air minimal 1,5 liter dari basecamp untuk berjaga-jaga di musim kemarau, dan tidak lupa membawa perlengkapan camp yang mumpuni karena cuaca bisa menjadi sangat dingin di area puncak.',
            ]
            );
            
         $waypoints = [
            [
                'name' => 'Pos 1 Kerun-kerun / Ompak-ompakan',
                'altitude' => 1650,
                'distance_from_prev' => 1.5 , // km 
                'estimated_time_minutes' => 90 ,
                'description' => 'Rute awal ini adalah lintasan adaptasi yang tergolong masih cukup landai dan sangat ramah bagi pendaki berbeban berat. Pendaki akan menyusuri area perkebunan warga, ladang rumput gajah, serta tanah terbuka. Sebelum tiba di pos ini, pendaki akan melewati titik ketersediaan air (Sendang Sanggar) dan area yang sering dijadikan camping ground oleh warga atau pendaki pemula bernama Kiteran.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 2 Banyu Urip',
                'altitude' => 1950,
                'distance_from_prev' => 1.5, // km 
                'estimated_time_minutes' => 90, 
                'description' => 'Elevasi tanah perlahan mulai menanjak seiring masuknya pendaki ke kawasan tutupan hutan yang lebih rimbun. Di Pos 2 ini terdapat sumber mata air bersih yang letaknya tidak jauh dari jalur utama, sehingga sangat ideal untuk memulihkan perbekalan air minum. Pos ini juga lekat dengan nuansa spiritual karena terdapat Watu Lapak, sebuah batu besar yang diyakini sebagai salah satu petilasan Prabu Brawijaya V saat beristirahat.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Pos 3 Cemoro Tukul / Hutan Cemara',
                'altitude' => 2350,
                'distance_from_prev' => 1.5 , // km 
                'estimated_time_minutes' => 120, 
                'description' => 'Menuju Pos 3, pendaki resmi memasuki kawasan "hutan perawan" Singolangu. Vegetasi berubah drastis didominasi oleh tegakan pohon cemara gunung yang sangat lebat dan tinggi menjulang. Trek pendakian didominasi oleh tanah liat padat yang bercampur dengan akar pohon besar. Suasana di sepanjang area ini sangat hening, sejuk, dan lembap karena minimnya sinar matahari yang bisa menembus tajuk pepohonan.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 4 Taman Edelweis / Taman Suwidak',
                'altitude' => 2650,
                'distance_from_prev' => 1.2,
                'estimated_time_minutes' => 150,
                'description' => 'Rute dari Pos 3 menuju Pos 4 adalah ujian fisik dan mental paling berat di jalur Cemoro Sewu. Pendaki akan melintasi anak tangga bebatuan padas yang meliuk-liuk ekstrem tepat di bibir jurang terbuka. Karena batas vegetasi pelindung sudah benar-benar tertinggal di bawah, tubuh akan langsung dihantam oleh embusan angin kencang yang sangat dingin. Namun, dari titik terbuka inilah lanskap Kabupaten Magetan, hamparan hutan, dan Telaga Sarangan terlihat sangat memukau jika cuaca sedang cerah. Pos 4 merupakan area terbuka yang hanya menyisakan reruntuhan fondasi bekas pos lama, sehingga pendaki dilarang berhenti terlalu lama di sini agar tidak terkena hipotermia.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Pos 5 Cokro Paningalan / Cokro Suryo',
                'altitude' => 2950,
                'distance_from_prev' => 1,
                'estimated_time_minutes' => 90,
                'description' => 'Lolos dari siksaan Tanjakan Pengik, rute menuju Pos 5 mulai membuka diri dari batas tutupan hutan yang pekat. Karena areanya yang sudah terbuka, embusan angin gunung akan mulai terasa menusuk tubuh. Dari titik ini, bentang alam menyajikan hadiah panorama spektakuler berupa view Kota Magetan dan keindahan Telaga Sarangan yang terlihat sangat jelas dari atas ketinggian.',
                'has_water_source' => false,
            ],
            [
                'name' => 'Hargo Dalem / Sendang Drajat',
                'altitude' => 3142,
                'distance_from_prev' => 1.5 ,
                'estimated_time_minutes' => 120,
                'description' => '  Menjelang akhir pendakian panjang, lintasan jalur Singolangu akhirnya akan bertemu (bergabung) dengan jalur populer lainnya (Cemoro Sewu/Kandang) di sekitar kawasan Sendang Drajat atau Hargo Dalem. Pendaki yang melewati jalur Singolangu mayoritas akan memilih beristirahat, mengisi air di sumur Sendang Drajat, dan mendirikan tenda (camp) di lembah ini. Area ini dikelilingi oleh banyak warung pecel legendaris untuk menghangatkan perut.',
                'has_water_source' => true,
            ],
            [
                'name' => 'Puncak Hargo Dumillah',
                'altitude' => 3265,
                'distance_from_prev' => 0.5,
                'estimated_time_minutes' => 45,
                'description' => 'Fase summit attack menuju titik tertinggi Gunung Lawu ini relatif singkat namun menuntut kehati-hatian. Medannya didominasi oleh tanjakan tanah padas berdebu tebal dan pecahan batu kapur yang mudah merosot saat dipijak, berselingan dengan rimbunan semak cantigi. Tiba di puncak, pendaki akan melihat monumen Tugu Hargo Dumilah yang berdiri kokoh di tengah hamparan tanah datar yang sangat lapang. Area ini sebagian ditumbuhi oleh bunga edelweis. Dari ketinggian ini, tersaji panorama 360 derajat yang luar biasa, di mana pada pagi hari yang jernih, jajaran Gunung Merapi, Merbabu, Sindoro, dan Sumbing akan terlihat berbaris rapi membelah lautan awan di ufuk barat.',
                'has_water_source' => false,
            ],
        ];

        foreach ($waypoints as $index => $wp) {
            $singolangu->waypoints()->updateOrCreate(
                ['name' => $wp['name']],
                array_merge($wp, ['order_index' => $index + 1])
            );
        }
    }
}
