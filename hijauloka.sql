-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2025 pada 03.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hijc7862_hijauloka`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `password`) VALUES
(1, 'admin', 'admin@hijauloka.com', '$2y$10$UlYPr4bLwvI8x5HxDDrhqeUroR6vsYwZde8C5.gsXSnXP0EtKMZ7m');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Tanaman Hias', 'tanaman-hias', '2025-05-12 08:15:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'draft',
  `author_id` int(10) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `category_id`, `status`, `author_id`, `views`, `created_at`, `updated_at`) VALUES
(5, 'Ruang Hidup yang Bernapas', 'ruang-hidup-yang-bernapas', '<p>Tanaman hias bukan sekadar elemen pelengkap dekorasi rumah. Ia adalah bentuk kehidupan yang tumbuh perlahan di sudut-sudut ruang, memberi warna, keseimbangan, dan rasa damai yang tak selalu bisa dijelaskan dengan kata-kata. Di tengah kesibukan dan hiruk-pikuk kehidupan modern, kehadiran tanaman hias menjadi pengingat bahwa segala sesuatu membutuhkan waktu untuk tumbuh dan berkembang.</p><p>Daya tarik tanaman hias terletak pada keindahan dan ketenangannya. Sebuah ruangan yang sebelumnya terasa datar bisa berubah hangat dan hidup hanya dengan menambahkan satu pot tanaman. Hijau daunnya menciptakan kontras alami terhadap warna dinding, cahaya matahari yang menembus sela-sela daun membentuk bayangan yang indah di lantai, dan setiap helai yang tumbuh adalah simbol kehidupan yang berjalan, diam-diam namun pasti.</p><p>Lebih dari itu, tanaman hias membawa energi positif. Bukan hanya dari sisi estetika, tapi juga secara psikologis. Banyak penelitian membuktikan bahwa kehadiran tanaman di dalam rumah atau kantor dapat mengurangi stres, meningkatkan suasana hati, dan bahkan membantu memperbaiki kualitas udara. Ini bukan sekadar mitos lama, melainkan hasil dari pemahaman kita yang semakin dalam terhadap hubungan antara manusia dan alam.</p><p>Menariknya, tren tanaman hias bukanlah hal baru. Sejak zaman dahulu, manusia telah membawa tumbuhan ke dalam rumah, baik untuk tujuan spiritual, pengobatan, maupun keindahan. Di masa sekarang, tren itu tumbuh lagi dengan wajah baru — lebih banyak orang muda mulai mengisi waktu luangnya dengan berkebun, bahkan di ruang-ruang kecil seperti apartemen dan kamar kos. Mereka merawat tanaman dengan penuh kasih, memberi nama, bahkan menganggapnya sebagai teman.</p><p>Tanaman hias mengajarkan kita banyak hal: tentang kesabaran, tentang perhatian, dan tentang kepekaan terhadap perubahan kecil. Daun yang menguning, batang yang mulai condong, atau tanah yang terlalu kering — semuanya memberi isyarat bahwa kehidupan itu rapuh, dan butuh dirawat dengan sepenuh hati.</p><p>Dalam dunia yang serba cepat ini, merawat tanaman bisa menjadi bentuk perlawanan kecil terhadap ritme yang melelahkan. Ia mengajak kita untuk berhenti sejenak, menyiram, memperhatikan, dan membiarkan diri kita ikut bertumbuh bersama mereka.</p>', '', 'uploads/blog/blog_1747228793.png', 1, 'published', 1, 12, '2025-05-14 13:19:53', '2025-05-21 02:02:34'),
(7, 'Keindahan yang Menyejukkan Rumah dan Hati  ', 'keindahan-yang-menyejukkan-rumah-dan-hati', '<p>Tanaman hias semakin populer di kalangan masyarakat, baik sebagai dekorasi rumah, penghias taman, maupun sebagai hobi yang menenangkan. Selain mempercantik ruangan, tanaman hias juga memberikan manfaat bagi kesehatan mental dan kualitas udara. Dalam artikel ini, kita akan membahas berbagai jenis tanaman hias, manfaatnya, serta tips merawatnya. &nbsp;</p><p>&nbsp;</p><p><strong>Jenis-Jenis Tanaman Hias Populer</strong></p><p>1. Tanaman Hias Daun&nbsp;<br>Tanaman hias daun memiliki keindahan pada bentuk dan warna daunnya. Beberapa contohnya: &nbsp;<br>- Aglaonema – Dikenal sebagai \"Sri Rezeki,\" memiliki daun berwarna merah, hijau, atau kuning.&nbsp;<br>- Monstera – Daunnya lebar dengan lubang alami, cocok untuk nuansa tropis. &nbsp;<br>- Calathea – Corak daunnya unik dan bergerak mengikuti cahaya. &nbsp;</p><p>&nbsp;</p><p>2. Tanaman Hias Bunga&nbsp;<br>Tanaman ini menarik perhatian karena bunganya yang indah dan warna-warni, seperti: &nbsp;<br>- Anggrek – Simbol keanggunan, cocok untuk indoor maupun outdoor.&nbsp;<br>- Peace Lily (Spathiphyllum) – Bunga putih yang elegan dan mampu membersihkan udara. &nbsp;<br>- Kamboja Jepang (Adenium) – Bunganya cerah dan batangnya unik. &nbsp;</p><p>&nbsp;</p><p>3. Tanaman Hias Gantung&nbsp;<br>Ideal untuk menghias teras atau ruangan sempit, contohnya: &nbsp;<br>- Lipstik (Aeschynanthus) – Bunga merah mirip lipstik. &nbsp;<br>- String of Pearls – Tanaman menjuntai dengan daun berbentuk mutiara. &nbsp;</p><p>&nbsp;</p><p>4. Tanaman Hias Sukulen &amp; Kaktus<br>Tahan kekeringan dan mudah dirawat, seperti: &nbsp;<br>- Echeveria – Sukulen berbentuk mawar dengan warna pastel. &nbsp;<br>- Opuntia Consolea – Bentuknya unik dan bisa tumbuh besar. &nbsp;</p><p>&nbsp;</p><p><strong>Manfaat Tanaman Hias &nbsp;</strong><br>1. Memperbaiki Kualitas Udara – Beberapa tanaman seperti Lidah Mertua (Sansevieria) dan Sirih Gading (Epipremnum aureum) dapat menyerap polutan. &nbsp;<br>2. Meningkatkan Mood &amp; Produktivitas – Warna hijau dan bunga segar membantu mengurangi stres. &nbsp;<br>3. Dekorasi Alami yang Estetik – Memberikan kesan asri dan sejuk di dalam rumah. &nbsp;<br>4. Hobi yang Menghasilkan – Banyak orang menjadikan tanaman hias sebagai bisnis sampingan.&nbsp;</p><p>&nbsp;</p><p><strong>Tips Merawat Tanaman Hias &nbsp;</strong><br>- Sesuaikan dengan Cahaya – Beberapa butuh sinar matahari penuh, sebagian lain lebih suka teduh. &nbsp;<br>- Siram Secukupnya – Jangan terlalu sering agar akar tidak membusuk. &nbsp;<br>- Gunakan Media Tanam yang Tepat – Campuran tanah, sekam, dan pupuk organik bisa membuat tanaman subur. &nbsp;<br>- Rutin Memangkas – Buang daun kering agar pertumbuhan lebih optimal. &nbsp;<br>&nbsp;<br>Tanaman hias bukan hanya sekadar penghias ruangan, tetapi juga membawa banyak manfaat bagi kehidupan sehari-hari. Dengan perawatan yang tepat, tanaman hias dapat tumbuh subur dan membuat rumah terasa lebih hidup. Jadi, tunggu apa lagi? Mulailah menghijaukan rumahmu dengan tanaman hias favorit!&nbsp;</p><p>&nbsp;</p><p>Ayo hijaukan hidupmu dengan tanaman hias! &nbsp;</p><p>&nbsp;</p><p>Artikel oleh [Daffina Nabilah]&nbsp;<br>Sumber gambar: Pinterest&nbsp;<br>&nbsp;</p>', '', 'uploads/blog/blog_1747378251.jpeg', 1, 'published', 1, 20, '2025-05-16 06:50:51', '2025-05-21 02:02:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_post_tags`
--

CREATE TABLE `blog_post_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `id_product`, `jumlah`) VALUES
(124, 29, 23, 1),
(130, 33, 21, 1),
(131, 34, 36, 1),
(132, 35, 35, 1),
(133, 36, 35, 1),
(134, 37, 36, 1),
(154, 4, 22, 4),
(158, 42, 22, 1),
(160, 45, 22, 1),
(165, 40, 22, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id_kategori`, `nama_kategori`, `id_admin`) VALUES
(2, 'Indoor', 1),
(3, 'Outdoor', 1),
(4, 'Mudah dirawat', 1),
(6, 'Tanaman penyaring udara', 1),
(7, 'Tanaman herbal dan aromaterapi', 1),
(16, 'Ramah hewan peliharaan', 1),
(17, 'Kaktus', 1),
(18, 'Sukulen', 1),
(19, 'Tanaman Daun', 1),
(20, 'Tanaman berbunga', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_order`
--

CREATE TABLE `detail_order` (
  `id_detail_order` int(10) UNSIGNED NOT NULL,
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_order`
--

INSERT INTO `detail_order` (`id_detail_order`, `id_order`, `id_product`, `jumlah`, `harga_satuan`) VALUES
(1, 166, 19, 1, 45000.00),
(2, 166, 36, 1, 25000.00),
(7, 169, 19, 1, 45000.00),
(19, 183, 22, 1, 85000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(10) UNSIGNED NOT NULL,
  `id_transaksi` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `featured_products`
--

CREATE TABLE `featured_products` (
  `id_featured` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `featured_products`
--

INSERT INTO `featured_products` (`id_featured`, `id_product`, `position`, `created_at`) VALUES
(90, 22, 1, '2025-05-19 08:10:53'),
(91, 69, 2, '2025-05-19 08:11:24'),
(92, 64, 3, '2025-05-19 08:11:26'),
(93, 62, 4, '2025-05-19 08:11:28'),
(94, 59, 5, '2025-05-19 08:11:31'),
(95, 50, 6, '2025-05-19 08:11:35'),
(96, 52, 7, '2025-05-19 08:11:37'),
(97, 56, 8, '2025-05-19 08:11:39'),
(98, 41, 9, '2025-05-19 08:11:42'),
(99, 39, 10, '2025-05-19 08:11:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_admin`
--

CREATE TABLE `log_admin` (
  `id_log` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `aksi` text NOT NULL,
  `tgl_aksi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `tgl_pemesanan` datetime NOT NULL,
  `stts_pemesanan` enum('pending','diproses','dikirim','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `total_harga` decimal(12,2) NOT NULL,
  `tgl_selesai` datetime DEFAULT NULL,
  `tgl_dikirim` datetime DEFAULT NULL,
  `tgl_batal` datetime DEFAULT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `stts_pembayaran` enum('belum_dibayar','lunas') NOT NULL DEFAULT 'belum_dibayar',
  `metode_pembayaran` enum('cod','midtrans','transfer') NOT NULL DEFAULT 'cod',
  `kurir` enum('hijauloka','jne','jnt') NOT NULL DEFAULT 'hijauloka',
  `ongkir` decimal(10,2) NOT NULL DEFAULT 0.00,
  `midtrans_order_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `tgl_pemesanan`, `stts_pemesanan`, `total_harga`, `tgl_selesai`, `tgl_dikirim`, `tgl_batal`, `id_admin`, `stts_pembayaran`, `metode_pembayaran`, `kurir`, `ongkir`, `midtrans_order_id`) VALUES
(153, 4, '2025-05-12 08:47:20', 'selesai', 90000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747032440'),
(154, 4, '2025-05-12 08:49:39', 'selesai', 5001.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747032579'),
(158, 4, '2025-05-14 14:33:47', 'dibatalkan', 75000.00, NULL, NULL, '2025-05-19 12:28:11', 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747226027'),
(161, 32, '2025-05-16 20:10:07', 'pending', 50000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747401007'),
(165, 38, '2025-05-18 17:16:49', 'selesai', 1005000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747563409'),
(166, 4, '2025-05-18 21:42:04', 'selesai', 85000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 15000.00, NULL),
(169, 4, '2025-05-18 21:46:44', 'selesai', 60000.00, NULL, NULL, NULL, 1, 'lunas', 'cod', 'hijauloka', 15000.00, NULL),
(181, 4, '2025-05-19 12:14:57', 'selesai', 255000.00, NULL, NULL, NULL, 1, 'lunas', 'cod', 'hijauloka', 5000.00, NULL),
(182, 4, '2025-05-19 12:58:02', 'selesai', 65000.00, NULL, NULL, NULL, 1, 'belum_dibayar', 'cod', 'hijauloka', 5000.00, NULL),
(183, 4, '2025-05-19 15:21:21', 'pending', 100000.00, NULL, NULL, NULL, 1, 'belum_dibayar', 'cod', 'hijauloka', 15000.00, NULL),
(184, 41, '2025-05-20 15:40:15', 'pending', 515000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747730415'),
(185, 41, '2025-05-20 15:41:41', 'selesai', 90000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747730501'),
(187, 44, '2025-05-20 22:30:20', 'pending', 90000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747755019'),
(188, 45, '2025-05-20 22:46:35', 'pending', 35000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747755994'),
(189, 4, '2025-05-21 09:26:35', 'pending', 505000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747794394'),
(190, 4, '2025-05-21 09:28:05', 'pending', 1005000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747794485'),
(191, 38, '2025-05-21 12:00:19', 'pending', 212000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747803619'),
(192, 38, '2025-05-21 12:04:40', 'pending', 90000.00, NULL, NULL, NULL, 1, 'lunas', 'midtrans', 'hijauloka', 5000.00, 'HJL-1747803880');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id_item`, `id_order`, `id_product`, `quantity`, `subtotal`) VALUES
(150, 158, 19, 2, 70000.00),
(153, 161, 19, 1, 45000.00),
(156, 165, 52, 1, 1000000.00),
(158, 182, 25, 1, 60000.00),
(159, 184, 56, 3, 510000.00),
(160, 185, 22, 1, 85000.00),
(162, 187, 22, 1, 85000.00),
(163, 188, 32, 1, 30000.00),
(164, 189, 69, 1, 500000.00),
(165, 190, 52, 1, 1000000.00),
(166, 191, 26, 1, 207000.00),
(167, 192, 22, 1, 85000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_proofs`
--

CREATE TABLE `payment_proofs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `verification_time` datetime NOT NULL,
  `is_verified` tinyint(1) DEFAULT 1,
  `verification_method` varchar(20) DEFAULT 'automatic',
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_product` int(10) UNSIGNED NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `desk_product` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `cara_rawat_video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_product`, `nama_product`, `desk_product`, `harga`, `stok`, `id_kategori`, `gambar`, `rating`, `id_admin`, `cara_rawat_video`) VALUES
(19, 'Peace Lily (Spathiphyllum wallisii)', 'Tanaman hias dengan daun hijau lebat dan bunga putih elegan yang menyerupai bunga lili. Peace Lily sangat cocok untuk indoor karena mampu menyaring polutan udara dan tumbuh baik di tempat teduh. Perawatannya mudah, hanya perlu disiram secara rutin dan ditempatkan di area lembap.\r\n\r\nKeunggulan:\r\n- Cocok untuk pemula\r\n- Memperbaiki kualitas udara\r\n- Bunga cantik & tahan lama', 45000.00, 33, NULL, 'peacelily3.jpg', NULL, 1, ''),
(20, 'Ketapang brazil (Terminalia catappa)', 'Tanaman pohon kecil dengan daun hijau cerah yang tumbuh membentuk payung alami. Ketapang Brazil sering digunakan sebagai tanaman ornamental di taman atau halaman rumah. Tahan panas dan mudah beradaptasi dengan berbagai kondisi tanah.\r\n\r\nKeunggulan:\r\n- Memberikan kesan tropis\r\n- Tahan cuaca panas\r\n- Pertumbuhan cepat', 450000.00, 28, NULL, 'Ketapang_brazil1.png', NULL, 1, ''),
(21, 'Bonsai', 'Koleksi bonsai eksklusif dengan bentuk artistik dan unik. Kami menyediakan berbagai jenis bonsai seperti beringin, serut, atau asam jawa yang telah dibentuk dengan teknik khusus. Tanaman ini cocok sebagai dekorasi meja atau hadiah bernilai tinggi.\r\n\r\nKeunggulan:\r\n- Nilai seni tinggi\r\n- Cocok untuk kolektor\r\n- Mempercantik ruangan', 300000.00, 10, NULL, 'bonsai.jpg,bonsai2.jpg', NULL, 1, ''),
(22, 'Sri Rezeki (Aglaonema)', 'Tanaman hias populer dengan corak daun merah, hijau, atau silver yang mencolok. Aglaonema dikenal sebagai \"Chinese Evergreen\" dan sangat adaptif di dalam ruangan. Perawatannya mudah, hanya membutuhkan cahaya tidak langsung dan penyiraman teratur.\r\n\r\nKeunggulan:\r\n- Corak daun unik\r\n- Tahan dalam ruangan\r\n- Perawatan minimal', 85000.00, 36, NULL, 'Algoena2.png', 5.0, 1, '47b9663413f609eef69956d7d8359307.mp4'),
(23, 'Dracaena', 'Tanaman hias berdaun panjang dengan variegasi hijau, kuning, atau merah. Dracaena efektif membersihkan udara dari polutan seperti formaldehida. Cocok untuk kantor atau ruang tamu dengan pencahayaan moderat.\r\n\r\nKeunggulan:\r\n- Anti polutan alami\r\n- Tahan kekeringan\r\n- Tampilan modern', 125000.00, 47, NULL, 'dracaena.jpg,dracaena2.jpg', NULL, 1, ''),
(24, 'Opuntia Consolea', 'Kaktus hias dengan bentuk pipih (seperti telinga kelinci) dan duri halus. Tanaman ini sangat tahan panas dan cocok untuk dekorasi minimalis atau taman kering.\r\n\r\nKeunggulan:\r\n- Unik dan estetik\r\n- Hampir tanpa perawatan\r\n- Tahan cuaca ekstrem', 59000.00, 15, NULL, 'Cactus_(Opuntia_Consolea)_-_Ø17cm_-_↕55cm.jpeg', NULL, 1, ''),
(25, 'Calathea', 'Tanaman hias eksklusif dengan daun bercorak indah dan warna memukau! Calathea dikenal sebagai \"Prayer Plant\" karena daunnya bergerak naik-turun seperti sedang berdoa saat malam hari. Calathea menyukai kelembapan tinggi dan cocok untuk terrarium atau ruangan dengan pencahayaan tidak langsung.\r\n\r\nKeunggulan:\r\n- Daun bergerak (nyctinasty)\r\n- Pola eksotis\r\n- Cocok untuk dekorasi instagramable', 60000.00, 20, NULL, 'Artificial_2_x_Calathea_Plant.jpeg', 5.0, 1, ''),
(26, 'Anggrek (Orchids)', 'Tanaman eksotis dengan bunga mempesona dan warna-warni mencolok! Anggrek cocok jadi pusat perhatian di ruangan atau taman. Beberapa jenis mekar tahan lama dan memiliki aroma harum.', 207000.00, 13, NULL, 'Orchids.jpeg', NULL, 1, ''),
(27, 'Echeveria Noble', 'Sukulen mungil dengan daun tebal berwarna hijau kebiruan dan bentuk roset yang simetris. Echeveria cocok untuk terrarium atau pot kecil di meja kerja.\r\n\r\nKeunggulan:\r\n- Minimalis & aesthetic\r\n- Perawatan super mudah\r\n- Tahan udara kering', 95000.00, 10, NULL, 'Echeveria_Noble_-_4_Inch.jpeg', NULL, 1, ''),
(28, 'Lili Paris (Spider Plant)', 'Tanaman dengan daun panjang bergaris hijau-putih yang menghasilkan anakan menggantung seperti laba-laba. Spider plant sangat mudah diperbanyak dan cocok untuk gantung di teras atau ruangan.\r\n\r\nKeunggulan:\r\n- Penyerap polutan efektif\r\n- Cocok untuk tanaman gantung\r\n- Tahan banting', 80000.00, 20, NULL, 'spider_plant.png', NULL, 1, ''),
(29, 'Lidah Buaya (Aloe Vera)', 'Tanaman sukulen dengan daun tebal bergerigi berisi gel bening yang terkenal untuk perawatan kulit, luka bakar, dan rambut.', 53000.00, 50, NULL, '5_Air_Purifying_Plants_Your_Home_Needs.jpeg', NULL, 1, ''),
(30, 'ZZ Plant (Zamioculcas Zamiifolia)', 'Tanaman dengan daun hijau mengilap dan batang tebal yang tumbuh tegak. Tahan di segala kondisi, bahkan di ruangan minim cahaya.', 458000.00, 25, NULL, 'Greenery_Unlimited__The_Future_of_Plants.jpeg', NULL, 1, ''),
(31, 'Money Plant (Epipremnum Aureum)', 'Tanaman merambat dengan daun berbentuk hati dan warna hijau-kuning yang cerah. Bisa ditanam di pot gantung atau media air.', 93000.00, 20, NULL, 'Epipremnum_aureum_-_Golden_Pothos.jpeg', NULL, 1, ''),
(32, 'Lavender', 'Tanaman berbunga ungu dengan aroma khas yang sering digunakan untuk minyak esensial dan pengusir nyamuk.', 30000.00, 19, NULL, 'Lavendula!.jpeg', NULL, 1, NULL),
(33, 'Bunny Ear Cactus (Opuntia Microdasys)', ' Kaktus pipih dengan duri halus berwarna emas atau putih. Tumbuh tegak dan cocok untuk dekorasi desktop.', 55000.00, 12, NULL, 'Opuntia_microdasys_-_Bunny_Ear_Cactus.jpeg,Opuntia_Microdasys_Rufida_-_Orange_-_2_5.jpeg', NULL, 1, ''),
(34, 'Jade Plant (Crassula Ovata)', 'Sukulen dengan daun tebal berbentuk oval dan batang kayu. Dipercaya membawa energi positif dalam Feng Shui.', 94000.00, 23, NULL, 'Qué_sucede_si_le_colocas_lentejas_a_tu_árbol_de_Jade2.jpeg', NULL, 1, ''),
(35, 'Fiddle Leaf Fig (Ficus lyrata)', 'Tanaman hias dengan daun lebar bertekstur seperti biola dan batang ramping. Cocok untuk nuansa tropis-modern. ', 300000.00, 20, NULL, 'Terrain-Fiddle-Leaf-Fig-Plant-Delivery-2-1024x1024.jpg', NULL, 1, ''),
(36, 'String of Pearls (Curio rowleyanus)', 'Sukulen unik dengan daun bulat seperti mutiara yang menjuntai indah. Cocok untuk pot gantung.', 25000.00, 12, NULL, 'String_of_Pearls.jpg', NULL, 1, ''),
(37, 'Areca Palm (Dypsis lutescens)', 'Tanaman dengan daun panjang menyerupai bulu burung, memberikan kesan tropis dengan tanaman tinggi, batang ramping, daun menjuntai rimbun berwarna hijau terang.', 147000.00, 25, NULL, 'Areca_Palm.jpg', NULL, 1, ''),
(38, 'Tiger Aloe (Aloe Vera Variegata)', 'Varietas aloe dengan daun hijau bercorak putih. Anti-inflamasi, baik untuk perawatan kulit.', 96000.00, 23, NULL, 'Aloe_Vera_Variegata.jpg', NULL, 1, ''),
(39, ' Baby Rubber Plant (Peperomia Obtusifolia)', 'Tanaman mini dengan daun hijau bundar mengkilap, batang kecil dan aman untuk hewan.', 98000.00, 23, NULL, 'Peperomia_Obtusifolia.jpg', NULL, 1, ''),
(40, 'Moonshine Sansevieria (Dracaena trifasciata)', 'Daun tebal, tegak, berwarna hijau keperakan, berguna sebagai penyaring udara, dan tahan kekeringan.', 27000.00, 25, NULL, 'Snake_Plant.jpg', NULL, 1, ''),
(41, 'Polka Dot Plant (Hypoestes phyllostachya)', 'Daun kecil berwarna merah muda, putih, atau merah berbintik, cocok untuk hiasan ruangan, dan tidak beracun untuk hewan.', 86000.00, 24, NULL, 'Polka_Dot_Plant.jpg', NULL, 1, ''),
(42, 'Coleus (Plectranthus scutellarioides)', 'Daun warna-warni cerah: ungu, merah, hijau untuk taman atau balkon.', 23000.00, 20, NULL, 'Coleus.jpg', NULL, 1, ''),
(43, 'Boston Fern (Nephrolepis exaltata)', ' Pakis lebat dengan daun menjunta berguna untuk menyaring udara, aman untuk kucing dan anjing.', 97000.00, 26, NULL, 'Boston_Fern.jpg', NULL, 1, ''),
(44, 'Birkin Philodendron (Philodendron)', 'Daun hijau tua dengan garis-garis putih seperti sapuan kuas. Elegan untuk dekorasi ruang tamu, tumbuh lambat dan mudah dirawat.', 152000.00, 20, NULL, 'Philodendron_Birkin.jpg', NULL, 1, ''),
(45, 'Wandering Jew (Tradescantia Zebrina)', 'Daun ungu-hijau metalik dengan garis perak. Cocok untuk tanaman gantung dan cepat tumbuh.', 147000.00, 22, NULL, 'Tradescantia_Zebrina.jpg', NULL, 1, ''),
(46, 'Rex Begonia (Begonia rex-cultorum)', 'Daun bertekstur dengan kombinasi warna merah, ungu, dan perak. Tanaman hias dekoratif yang cocok untuk interior modern.', 52000.00, 23, NULL, 'Begonia_Rex.jpg', NULL, 1, ''),
(47, 'Rosemary (Salvia rosmarinus)', 'Tanaman herbal aromatik dengan daun jarum dan bunga ungu kecil. Aromanya segar dan sering digunakan untuk masakan atau minyak esensial. Tumbuh subur di outdoor dengan sinar matahari penuh. Bisa juga ditanam di pot sebagai tanaman hias sekaligus bumbu dapur.', 81000.00, 12, NULL, 'Herb_Collection_-_Rosemary.jpeg', NULL, 1, ''),
(48, 'Bromelia (Bromeliaceae)', 'Tanaman eksotis dengan daun keras dan bunga berwarna cerah (merah, kuning, atau pink). Menyukai kelembapan tinggi dan cahaya tidak langsung. Bunganya bisa bertahan berbulan-bulan, cocok sebagai dekorasi meja atau sudut ruangan.', 160000.00, 20, NULL, 'How_to_Care_for_Bromeliads.jpeg', NULL, 1, ''),
(49, 'Fairy Castle Cactus (Acanthocereus tetragonus)', 'Kaktus mini berbentuk seperti menara kastil, tumbuh vertikal dengan duri halus. Cocok untuk meja kerja atau rak. Hanya butuh penyiraman 2 minggu sekali.', 170000.00, 20, NULL, 'Fairy_Castle_Cactus_Care_Guide.jpeg', NULL, 1, ''),
(50, 'Janda Bolong (Monstera Deliciosa \'Albo Variegata\')', 'Tanaman eksklusif dengan daun berlubang alami dan variegasi putih. Kolektor item yang sangat dicari.', 7500000.00, 5, NULL, 'Monstera_Deliciosa_Albo_Variegata_-_The_Most_Expensive_Plants_in_the_World_.jpeg', NULL, 1, '55c58708e5e0a75c73fc14dc48675543.mp4'),
(51, 'Tanaman Lipstik (Hoya Carnosa \'Compacta\')', 'Tanaman gantung dengan daun keriting dan bunga berbentuk bintang beraroma manis.', 350000.00, 10, NULL, 'Carnosa_Hoya.jpeg', NULL, 1, ''),
(52, 'Fiddle Leaf Fig (Ficus lyrata)', 'Tanaman tinggi dengan daun lebar berbentuk biola, populer untuk dekorasi interior modern.', 1000000.00, 13, NULL, 'Fiddle_Leaf_Fig_Potted_Houseplant___Trendy_Houseplants.jpeg,Fiddle_Leaf_Fig_For_Indoor_Plants_Ideas_(1).jpeg', 5.0, 1, ''),
(53, 'String of Hearts (Ceropegia woodii)', 'Tanaman gantung dengan daun kecil berbentuk hati dan corak marmer unik.', 220000.00, 20, NULL, 'Ceropegia_woodii_-_String_of_Hearts_-_20cm_(12cm_pot).jpeg', NULL, 1, ''),
(54, 'Bird of Paradise (Strelitzia reginae)', 'Tanaman dengan pola daun menyerupai kulit ular dan warna ungu di bagian bawah daun.', 380000.00, 25, NULL, 'Strelitzia_reginae_-_Bird_of_Paradise.jpeg', NULL, 1, NULL),
(55, 'Ponytail Palm (Beaucarnea recurvata)', 'Tanaman unik dengan batang bengkak dan daun panjang seperti ekor kuda.', 450000.00, 15, NULL, 'Beaucarnea_-_Pony_Tail_Palm_-_Branched.jpeg', NULL, 1, NULL),
(56, 'Peperomia Corak Semangka (Peperomia argyreia\'Watermelon\')', 'Tanaman kecil dengan daun tebal bergaris menyerupai kulit semangka.', 170000.00, 12, NULL, 'Watermelon_Peperomia_Plant.jpeg,Watermelon_Peperomia_Plant_Live_Heart_Shaped_Succulents_-_Pet_Friendly_Plants_Live_Fully_Rooted_Houseplant_for_Home_Office_Wedding_Decorations_-_Birthday_Mothers_Day_Gift.jpeg', NULL, 1, '4e12ba5368e149d2f3176408a7799ab7.mp4'),
(57, 'Bougenville', 'Tanaman semak merambat ini menghasilkan bunga berwarna mencolok seperti ungu, pink, dan merah. Cocok untuk taman atau pagar rumah. Tahan panas dan membutuhkan banyak cahaya matahari.', 55000.00, 12, NULL, 'Bougenville.jpg', NULL, 1, NULL),
(58, 'Zebra Cactus (Haworthia)', 'Sukulen mungil dengan pola garis putih pada daun hijau gelap. Sangat cocok untuk ruangan kecil, terrarium, atau hadiah. Tidak memerlukan banyak cahaya dan air.', 75000.00, 10, NULL, 'haworthia.jpg', NULL, 1, ''),
(59, ' Chinese Money Plant (Pilea Peperomioides)', 'Memiliki daun bulat seperti koin dan batang panjang ramping. Disebut sebagai tanaman pembawa keberuntungan. Estetik dan populer di kalangan pecinta tanaman dekoratif minimalis.', 100000.00, 15, NULL, 'pilea.jpg', NULL, 1, ''),
(60, 'Dragon Scale Alocasia ( Alocasia baginda)', 'Daun unik menyerupai sisik naga dengan tekstur mengilap dan urat daun keperakan. Tanaman ini menyukai kelembapan tinggi dan cahaya teduh. Memberikan tampilan tropis yang mewah dan sangat disukai kolektor tanaman hias eksotis.', 590000.00, 5, NULL, 'Alocasia-Dragon-Scale.jpg', NULL, 1, ''),
(61, 'Variegated Sweetheart Hoya (Hoya Kerrii Variegata)', 'Tanaman berbentuk hati yang sangat imut dan populer sebagai hadiah. Varietas variegata memiliki tepi daun putih krem yang indah. Termasuk sukulen, jadi perawatannya minim. Lambat tumbuh tapi tahan lama, cocok untuk meja kerja atau rak dekoratif.', 150000.00, 15, NULL, 'Hoya_Kerrii_Variegata.jpg', NULL, 1, ''),
(62, 'Flaming Katy (Kalanchoe blossfeldiana)', 'Tanaman sukulen kecil dengan bunga warna cerah seperti merah, kuning, oranye, dan pink. Tahan kekeringan dan cocok sebagai tanaman meja yang mempercantik ruangan.', 50000.00, 25, NULL, 'Kalanchoe_blossfeldiana.jpg', NULL, 1, ''),
(63, ' African Violet (Streptocarpus sect. Saintpaulia)', 'Tanaman kecil dengan bunga ungu, pink, atau putih yang cantik dan tahan lama. Cocok untuk pot kecil di meja atau jendela dengan cahaya tidak langsung. Mudah dirawat dan sering dijadikan hadiah.', 60000.00, 20, NULL, 'African_Violet_(Saintpaulia).jpg', NULL, 1, ''),
(64, 'Cast Iron Plant (Aspidistra elatior)', 'Tanaman dengan daun hijau gelap yang tahan banting, cocok untuk ruangan minim cahaya dan pemula. Aman untuk hewan peliharaan dan tahan terhadap kondisi lingkungan yang keras.', 180000.00, 30, NULL, 'Cast_Iron_Plant_(Aspidistra_elatior).jpg', NULL, 1, 'b69353cbe510dc982ffe420808e62ac8.mp4'),
(65, 'Weeping Fig (Ficus Benjamina)', 'Pohon kecil dengan daun hijau mengkilap yang rimbun, cocok sebagai tanaman pelindung atau hiasan halaman. Tumbuh baik di tempat yang mendapat sinar matahari sebagian.\r\n\r\n', 300000.00, 15, NULL, 'Ficus_Benjamina_(Weeping_Fig).jpg', NULL, 1, ''),
(66, 'Cape Jasmine (Gardenia jasminoides)', 'Semak dengan bunga putih beraroma kuat dan mewah. Ideal untuk taman halaman atau sebagai tanaman pagar. Membutuhkan cahaya matahari penuh dan kelembapan tanah yang cukup.', 200000.00, 10, NULL, 'Gardenia_jasminoides.jpg', NULL, 1, ''),
(69, 'Lidah Mertua (Dracaena trifasciata \'Snake Plant\')', 'Lidah mertua, yang secara ilmiah disebut Sansevieria trifasciata (atau dikenal sebagai Sansevieria spp), adalah tanaman hias populer dengan daun panjang, tegak, dan berbentuk pedang. ', 500000.00, 11, NULL, 'lidahmertua13.jpg,lidahmertua28.jpg', NULL, 1, 'd0341a2ef92cd4724dd4dccf60199f53.mp4'),
(74, 'Swiss Cheese Vine (Monstera adansonii)', 'Tanaman Hias Eksklusif dengan Daun Berbentuk Jantung Berlubang Alami\r\n\r\nSpesifikasi Produk:\r\n\r\n- Nama Ilmiah: Monstera adansonii\r\n- Ukuran: Tinggi ±20-30 cm (termasuk pot)\r\n- Media Tanam: Campuran tanah porous dan sekam bakar\r\n- Pot: Polybag/pot plastik drainase baik (opsional upgrade pot estetik)\r\n- Perawatan: Mudah, cocok untuk pemula\r\n\r\nKeunggulan:\r\n✔ Daun Unik – Lubang alami (fenestrasi) memberi kesan tropis dan modern.\r\n✔ Tahan Banting – Adaptif di ruangan dengan cahaya rendah hingga sedang.\r\n✔ Pembersih Udara – Menyerap polutan dan meningkatkan kualitas udara.\r\n✔ Tumbuh Merambat – Cocok untuk digantung atau dirambatkan di rak/totem.', 200000.00, 30, NULL, 'Plantas_de_interior_natural_monstera_(25_-_30_cm).jpeg', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_category`
--

CREATE TABLE `product_category` (
  `id_product` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product_category`
--

INSERT INTO `product_category` (`id_product`, `id_kategori`) VALUES
(19, 2),
(19, 6),
(19, 20),
(20, 2),
(20, 3),
(20, 19),
(21, 2),
(21, 3),
(22, 2),
(23, 2),
(23, 6),
(23, 16),
(23, 19),
(24, 4),
(24, 17),
(24, 18),
(25, 2),
(25, 6),
(25, 16),
(25, 19),
(26, 2),
(26, 20),
(27, 3),
(27, 4),
(27, 18),
(27, 19),
(28, 2),
(28, 3),
(28, 4),
(28, 6),
(28, 16),
(29, 2),
(29, 4),
(29, 7),
(29, 16),
(30, 2),
(30, 4),
(30, 6),
(31, 2),
(31, 4),
(31, 6),
(31, 19),
(32, 3),
(32, 7),
(32, 20),
(33, 3),
(33, 4),
(33, 17),
(34, 2),
(34, 3),
(34, 4),
(34, 18),
(35, 2),
(35, 19),
(36, 2),
(36, 18),
(37, 2),
(37, 6),
(38, 2),
(38, 4),
(39, 2),
(39, 16),
(40, 2),
(40, 4),
(41, 16),
(41, 19),
(42, 3),
(42, 19),
(43, 6),
(43, 16),
(44, 2),
(44, 4),
(44, 19),
(45, 2),
(45, 18),
(46, 2),
(46, 19),
(47, 3),
(47, 7),
(48, 2),
(48, 20),
(49, 4),
(49, 17),
(50, 2),
(50, 19),
(51, 2),
(51, 20),
(52, 2),
(52, 19),
(53, 2),
(53, 18),
(54, 2),
(54, 19),
(55, 2),
(55, 3),
(56, 2),
(56, 19),
(57, 3),
(57, 20),
(58, 2),
(58, 4),
(58, 18),
(59, 2),
(59, 4),
(59, 19),
(60, 2),
(60, 19),
(61, 2),
(61, 18),
(62, 2),
(62, 18),
(62, 20),
(63, 2),
(63, 20),
(64, 2),
(64, 4),
(64, 16),
(65, 3),
(65, 19),
(66, 3),
(66, 7),
(66, 20),
(69, 2),
(69, 3),
(74, 2),
(74, 6),
(74, 19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id_image` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `qna_product`
--

CREATE TABLE `qna_product` (
  `id_qna` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `upvote` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `review_rating`
--

CREATE TABLE `review_rating` (
  `id_review` int(10) UNSIGNED NOT NULL,
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `ulasan` text NOT NULL,
  `foto_review` varchar(255) DEFAULT NULL,
  `tgl_review` datetime NOT NULL,
  `stts_review` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `review_rating`
--

INSERT INTO `review_rating` (`id_review`, `id_order`, `id_user`, `id_product`, `rating`, `ulasan`, `foto_review`, `tgl_review`, `stts_review`) VALUES
(1, 153, 4, 22, 5, 'BAGUSSS BANGET', NULL, '2025-05-14 14:53:37', 'disetujui'),
(2, 165, 38, 52, 5, 'Terimakasih seller! tanamannya bagus bangeeett dan pengirimannya super safetyyy! ', NULL, '2025-05-19 08:45:21', 'disetujui'),
(4, 182, 4, 25, 5, ' Bagus Gilee\r\n', NULL, '2025-05-21 09:27:24', 'disetujui'),
(5, 185, 41, 22, 5, 'Bagusssssssssss', NULL, '2025-05-20 15:48:31', 'disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_label` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `rt` varchar(10) DEFAULT NULL,
  `rw` varchar(10) DEFAULT NULL,
  `house_number` varchar(20) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `jarak` decimal(10,2) NOT NULL DEFAULT 0.00,
  `detail_address` text DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `recipient_name`, `phone`, `address_label`, `address`, `rt`, `rw`, `house_number`, `postal_code`, `jarak`, `detail_address`, `is_primary`, `created_at`) VALUES
(1, 4, 'Dea Amelia', '0812131311323', 'Rumah', 'Jl Raya Subang', '020', '050', '19', '04423', 0.00, 'Depan Warung', 1, '2025-04-29 02:39:11'),
(2, 4, 'Mamah Dea', '082782487924', 'Rumah', 'RW 09, Manggarai Selatan, Tebet, Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Jawa, 12850, Indonesia', '020', '0', '19', '12850', 0.00, 'dekat warung', 0, '2025-04-29 03:15:31'),
(5, 27, 'MarkZucky', '081123123134', 'Rumah', 'Tanjungpura, Karawang Barat, Karawang, Jawa Barat, Jawa, 41316, Indonesia', '020', '016', '15', '41316', 0.00, 'Dekat Mana aja', 1, '2025-05-07 02:47:50'),
(7, 29, 'Alexander', '082782487924', 'Rumah', 'Jl. Veteran, Karangpawitan, Karawang Barat, Karawang, Jawa Barat, Jawa, 41315, Indonesia', '020', '016', '48', '41315', 0.00, 'Dekat abang bakso', 1, '2025-05-16 06:53:10'),
(9, 29, 'Mamah Alex', '081323123112134', 'Rumah', 'Jl. Veteran, Karangpawitan, Karawang Barat, Karawang, Jawa Barat, Jawa, 41315, Indonesia', '020', '010', '23', '41315', 0.00, 'aaaa', 0, '2025-05-16 06:57:41'),
(10, 30, 'Daffina', '0895621430501', 'Rumah', 'Kobe japan', '2', '1', '11', '433723', 0.00, 'Rumah Tingkat 3 cat putih', 1, '2025-05-16 09:04:54'),
(11, 31, 'Fafai', '0856133316566', 'Rumah', 'Jl Raya Sabajaya', '039', '022', '72', '41357', 0.00, '-', 1, '2025-05-16 13:12:29'),
(12, 38, 'Daffina ', '0895621430501', 'rumah', 'Kobe', '1', '1', '1440', '42373', 0.00, 'Rumah tingkat 3 cat putih pager item', 1, '2025-05-18 10:16:37'),
(13, 41, 'Taufik', '0895621430501', 'Rumah', 'Kampus B Horizon University Indonesia, KM 1, Jalan Pangkal Perjuangan, Tanjungpura, Karawang Barat, Karawang, Jawa Barat, Jawa, 41316, Indonesia', '1', '1', '2', '41316', 0.00, 'Rumah tembok putih', 1, '2025-05-20 08:40:04'),
(14, 44, 'amanda', '0987654321', 'rumah', 'bekasi timur', '002', '002', '12', '13', 0.00, 'cat warna putih', 1, '2025-05-20 15:29:56'),
(15, 45, 'alfathunisa', '0987654321', 'rumah', 'cikarang', '009', '008', '23', '13', 0.00, 'cat merah', 1, '2025-05-20 15:46:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('transfer','e-wallet','cod') NOT NULL,
  `status_pembayaran` enum('pending','lunas','gagal') NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `id_admin` int(10) UNSIGNED DEFAULT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `payment_response` text DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `order_id`, `user_id`, `total_bayar`, `metode_pembayaran`, `status_pembayaran`, `tanggal_transaksi`, `id_admin`, `payment_token`, `payment_response`, `bukti_pembayaran`, `expired_at`) VALUES
(134, 153, 4, 90000.00, '', 'pending', '2025-05-12 08:47:20', NULL, '4f9e7427-3af3-4140-866b-f0447ece256c', '{\"snap_token\":\"4f9e7427-3af3-4140-866b-f0447ece256c\"}', NULL, '2025-05-13 08:47:20'),
(135, 154, 4, 5001.00, '', 'pending', '2025-05-12 08:49:39', NULL, '9e7470a7-52a3-4ae6-9b0c-d5a89a8274cf', '{\"snap_token\":\"9e7470a7-52a3-4ae6-9b0c-d5a89a8274cf\"}', NULL, '2025-05-13 08:49:39'),
(139, 158, 4, 75000.00, '', 'pending', '2025-05-14 14:33:47', NULL, '34719fd9-1c06-4b1a-b613-4ffdad126a4e', '{\"snap_token\":\"34719fd9-1c06-4b1a-b613-4ffdad126a4e\"}', NULL, '2025-05-15 14:33:47'),
(142, 161, 32, 50000.00, '', 'pending', '2025-05-16 20:10:07', NULL, 'c4b2fe49-91de-454f-921d-66903c807a45', '{\"snap_token\":\"c4b2fe49-91de-454f-921d-66903c807a45\"}', NULL, '2025-05-17 20:10:07'),
(146, 165, 38, 1005000.00, '', 'pending', '2025-05-18 17:16:49', NULL, '5cde1fce-b576-4266-9540-9a86448a2b59', '{\"snap_token\":\"5cde1fce-b576-4266-9540-9a86448a2b59\"}', NULL, '2025-05-19 17:16:49'),
(147, 181, 4, 250000.00, 'cod', 'pending', '2025-05-19 12:14:57', NULL, 'DUMMY-682abe51efd78', '{\"dummy\":true}', NULL, NULL),
(148, 182, 4, 60000.00, 'cod', 'pending', '2025-05-19 12:58:02', NULL, 'DUMMY-682ac86a26348', '{\"dummy\":true}', NULL, NULL),
(149, 184, 41, 515000.00, '', 'pending', '2025-05-20 15:40:15', NULL, 'a638a7fa-c46a-4002-8dd7-30c2eafe0ec3', '{\"snap_token\":\"a638a7fa-c46a-4002-8dd7-30c2eafe0ec3\"}', NULL, '2025-05-21 15:40:15'),
(150, 185, 41, 90000.00, '', 'pending', '2025-05-20 15:41:41', NULL, 'af4ef458-8379-42ff-9234-dd4c2c233807', '{\"snap_token\":\"af4ef458-8379-42ff-9234-dd4c2c233807\"}', NULL, '2025-05-21 15:41:41'),
(152, 187, 44, 90000.00, '', 'pending', '2025-05-20 22:30:20', NULL, '09a6d29d-a002-43ef-898d-c5022a6f199a', '{\"snap_token\":\"09a6d29d-a002-43ef-898d-c5022a6f199a\"}', NULL, '2025-05-21 22:30:20'),
(153, 188, 45, 35000.00, '', 'pending', '2025-05-20 22:46:35', NULL, 'dc46b016-2bf9-4b69-a994-ea7625e3fc5c', '{\"snap_token\":\"dc46b016-2bf9-4b69-a994-ea7625e3fc5c\"}', NULL, '2025-05-21 22:46:35'),
(154, 189, 4, 505000.00, '', 'pending', '2025-05-21 09:26:35', NULL, '3698194b-8f02-4ba8-b173-cb34a42aa6b2', '{\"snap_token\":\"3698194b-8f02-4ba8-b173-cb34a42aa6b2\"}', NULL, '2025-05-22 09:26:35'),
(155, 190, 4, 1005000.00, '', 'pending', '2025-05-21 09:28:05', NULL, '96e7f269-2431-401d-99ae-3e2779983556', '{\"snap_token\":\"96e7f269-2431-401d-99ae-3e2779983556\"}', NULL, '2025-05-22 09:28:05'),
(156, 191, 38, 212000.00, '', 'pending', '2025-05-21 12:00:19', NULL, '8f72857e-9b03-4dfe-99c2-87e5d6a97e10', '{\"snap_token\":\"8f72857e-9b03-4dfe-99c2-87e5d6a97e10\"}', NULL, '2025-05-22 12:00:19'),
(157, 192, 38, 90000.00, '', 'pending', '2025-05-21 12:04:40', NULL, 'f18c84ec-885b-4bc8-8702-9e605b765c3b', '{\"snap_token\":\"f18c84ec-885b-4bc8-8702-9e605b765c3b\"}', NULL, '2025-05-22 12:04:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `shipping_address` text DEFAULT NULL,
  `no_tlp` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `alamat`, `shipping_address`, `no_tlp`, `profile_image`) VALUES
(3, 'fai', 'fai123@gmail.com', '123', 'krwng', NULL, '08123', NULL),
(4, 'Dea Amelia', 'dea123@gmail.com', '$2y$10$ouxH5wqI0of9Epuzi98IA.bP7IRPBJ8ti.2E7G4JMLIf2naurzyDa', 'Subang', NULL, '0812444222', NULL),
(6, 'Daffina', 'daffina123@gmail.com', '123', 'Cikampek', NULL, '082479131', NULL),
(7, 'Aisyah', 'asiah234@gmail.com', '123', 'Karawang', NULL, '9981481131', NULL),
(10, 'Daffina Nabillah', 'dep456@gmail.com', '123', 'Cikampek', NULL, '09838733', NULL),
(16, 'Depina', 'dep567@gmail.com', '123', 'Cikampek', NULL, '0837474883', NULL),
(19, 'Muhamad Rifai', 'fai789@gmail.com', '$2y$10$JAWk6XEneiAm67FGTJ5h/ePFBzmkPBlSJ61tNPxhcanpOSTWSD/8m', 'Karawang', NULL, '08123456789', NULL),
(22, 'Rifai', 'faifai04@gmail.com', '123456', 'Karawang', NULL, '08380310133', NULL),
(23, 'Muhamad Rifai', 'faifai12@gmail.com', '123456', 'Karawang', NULL, '083189123144', NULL),
(26, 'Elon Must', 'lon123@gmail.com', '$2y$10$Y0BS0c/GcEw2xSLMfxKE9usqeXVIHtcypkmNCkIOQJ6.o6lHhIFxu', 'Karawang', NULL, '08779898221', NULL),
(27, 'MarZucky', 'zuck123@gmail.com', '$2y$10$9xdptMkcBzugKKz7mOiUkO00DTM.zWuq7VVxDW.br/QD.Ov25hCYq', 'Karawang', NULL, '081311343143', NULL),
(28, 'dep', 'top123@gmail.com', '$2y$10$ELQejxjUXhx/65CAj5NCceCP3V.RVYNBriyqK8d18d5BizDUsRh2G', 'Cikampek', NULL, '082837378182', NULL),
(29, 'Alexander', 'alex123@gmail.com', '$2y$10$XDGwKAdN.LAUPoem/tAvhuEXvJW.C4hWTcl5X7ZAeAuy8/flHo1I.', 'Yunani', NULL, '0813942989824', NULL),
(30, 'Daffinahceah', 'dffnanas@gmail.comn', '$2y$10$302kgA7B1d3Hmqwvus.be.Ne/oqZc7BGvRChPf6wZ2MZxuo8AeeGO', 'Kobe', NULL, '0895621430501', NULL),
(31, 'Fafai', 'fai890@gmail.com', '$2y$10$Buo3PIF1.8m4G5BtJfdEfe4K3VCHRi0HpuxpUwEjbwY3BCeEdLEDS', 'Amerika Kulon', NULL, '0818373728', NULL),
(32, 'shakilla', 'shakilla@gmail.com', '$2y$10$/09.NwAQ0yDaxWoaAm8Aze9TOtFrtmG4qI5i5tflMvh4a9sMC2jGS', 'karawang', NULL, '0812345678', NULL),
(33, 'chelsea anindya', 'chlsanindya@gmail.com', '$2y$10$Eqg.SgAgp/aZ.rhdoyT6VOfjYbCeuH5Y1lXUkbEbFemS9pj5ihQzu', 'karawang jawa barat', NULL, '085719684127', NULL),
(34, 'Temporary User', 'temp_1747502546@example.com', '$2y$10$WbFff3x/dMDi5sFEG2NwceOgUb3me.sDnuB8Ei4D5V7ataps5lZP2', '', NULL, '', NULL),
(35, 'Temporary User', 'temp_1747502554@example.com', '$2y$10$hMhwnCt.VtcQjY8smOh7YOy0biV0zHAN0hl7nY5VsbVohDXdRf/DS', '', NULL, '', NULL),
(36, 'Temporary User', 'temp_1747502608@example.com', '$2y$10$0UdRcOKJsNAHeXZ/IKP5F.y852wbn.CFrG2yQqvU81vazb.sCuuhG', '', NULL, '', NULL),
(37, 'Temporary User', 'temp_1747529901@example.com', '$2y$10$WYmkhrxvlEevZfl9QC9jJul0OgEJkx7flaLTheRlR6r81k7VPdMBO', 'Temporary Address', NULL, '0000000000', NULL),
(38, 'Daffina', 'dffnanas@gmail.com', '$2y$10$eeml86X.iIIvBeO/IrxxmuOqXb.Gj9nI4E88h7mCxL3G7.75sls9u', 'Kobe', NULL, '0895621430501', NULL),
(39, 'aysa', 'aysanrhidayah@gmail.com', '$2y$10$2feEhAfX1/a5qZnDY1xwjeTmsH8FvIR/UZOAfQjXXTOQZ0XO8kz4W', 'cipuzuk', NULL, '08559882083', NULL),
(40, 'yourgmail', 'yourgmail@gmail.com', '$2y$10$Ry9zIBxJmuRs94HEzPoDp.QuJDu2bvSWH0mLsjfP.q193Gb7.9fo2', 'Karawang', NULL, '082738287373', NULL),
(41, 'Taufik', 'taufik123@gmail.com', '$2y$10$JSGJlgOQgH8lCvYd8bwHtuV1XxiFodPZegRDNCX45BowfPSafLszK', 'Karawang', NULL, '0895621430501', NULL),
(42, 'putri', 'putri@gmail.com', '$2y$10$FhlYyfRqIKLdVh2G0Sp7K.AvqknwyjqI5luYwDuXVPS27N7uWZ2YW', 'bekasi', NULL, '09845678345', NULL),
(43, 'aya', 'aya@gmail.com', '$2y$10$NpkcB.gOsG3KTY2sd8sMMuoyc2GKu8GHOTo.P938AfLfEKj/2885a', 'karawang', NULL, '0987654321', NULL),
(44, 'amanda', 'amanda@gmail.com', '$2y$10$w/8hEkVKx1m/yICicFUvcuRlOm29qk9SOXEPmx0xO3SpwEHQe98qa', 'bekasi', NULL, '0987654321', NULL),
(45, 'alfathunisa', 'alfathunisa@gmail.com', '$2y$10$tOnG45Dl5EzJ7vzzvZaXBuKjZk.212x9S7iRCNjtW8rNIbH8EL0tC', 'cikarang', NULL, '0987654312', NULL),
(46, 'hehehehe', 'hehe@gmail.com', '$2y$10$010Oq5u/dOLp2Er89wkr2OjH5Mf8bBFgAexlp2pXPN7Xt/BDoxeYW', 'kjsadhfkjsfdsfdsf', NULL, '09089238924234', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_product` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`, `id_user`, `id_product`) VALUES
(11, 19, 22),
(69, 4, 23),
(79, 29, 21),
(80, 30, 19),
(81, 4, 19),
(82, 30, 26),
(83, 30, 24),
(84, 30, 30),
(85, 32, 19),
(86, 38, 52),
(87, 4, 22),
(88, 44, 22),
(89, 45, 22);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indeks untuk tabel `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indeks untuk tabel `blog_post_tags`
--
ALTER TABLE `blog_post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indeks untuk tabel `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `cart_id_user_foreign` (`id_user`),
  ADD KEY `cart_id_product_foreign` (`id_product`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `category_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `detail_order`
--
ALTER TABLE `detail_order`
  ADD PRIMARY KEY (`id_detail_order`),
  ADD KEY `detail_order_id_order_foreign` (`id_order`),
  ADD KEY `detail_order_id_product_foreign` (`id_product`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `featured_products`
--
ALTER TABLE `featured_products`
  ADD PRIMARY KEY (`id_featured`),
  ADD UNIQUE KEY `position` (`position`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `log_admin`
--
ALTER TABLE `log_admin`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `log_admin_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `order_id_user_foreign` (`id_user`),
  ADD KEY `order_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `payment_proofs`
--
ALTER TABLE `payment_proofs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `product_id_kategori_foreign` (`id_kategori`),
  ADD KEY `product_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id_product`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `qna_product`
--
ALTER TABLE `qna_product`
  ADD PRIMARY KEY (`id_qna`),
  ADD KEY `qna_product_id_user_foreign` (`id_user`),
  ADD KEY `qna_product_id_product_foreign` (`id_product`);

--
-- Indeks untuk tabel `review_rating`
--
ALTER TABLE `review_rating`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `review_rating_id_order_foreign` (`id_order`),
  ADD KEY `review_rating_id_user_foreign` (`id_user`),
  ADD KEY `review_rating_id_product_foreign` (`id_product`);

--
-- Indeks untuk tabel `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_order` (`order_id`),
  ADD KEY `fk_transaksi_user` (`user_id`),
  ADD KEY `fk_transaksi_admin` (`id_admin`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- Indeks untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD KEY `wishlist_id_user_foreign` (`id_user`),
  ADD KEY `wishlist_id_product_foreign` (`id_product`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `blog_post_tags`
--
ALTER TABLE `blog_post_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `detail_order`
--
ALTER TABLE `detail_order`
  MODIFY `id_detail_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `featured_products`
--
ALTER TABLE `featured_products`
  MODIFY `id_featured` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT untuk tabel `log_admin`
--
ALTER TABLE `log_admin`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT untuk tabel `payment_proofs`
--
ALTER TABLE `payment_proofs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id_image` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `qna_product`
--
ALTER TABLE `qna_product`
  MODIFY `id_qna` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `review_rating`
--
ALTER TABLE `review_rating`
  MODIFY `id_review` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_blogposts_admin` FOREIGN KEY (`author_id`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `blog_post_tags`
--
ALTER TABLE `blog_post_tags`
  ADD CONSTRAINT `blog_post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `cart_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `detail_order`
--
ALTER TABLE `detail_order`
  ADD CONSTRAINT `detail_order_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_order_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `featured_products`
--
ALTER TABLE `featured_products`
  ADD CONSTRAINT `featured_products_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `log_admin`
--
ALTER TABLE `log_admin`
  ADD CONSTRAINT `log_admin_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `order_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `product_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `category` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `category` (`id_kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `qna_product`
--
ALTER TABLE `qna_product`
  ADD CONSTRAINT `qna_product_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `qna_product_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `review_rating`
--
ALTER TABLE `review_rating`
  ADD CONSTRAINT `review_rating_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
  ADD CONSTRAINT `review_rating_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_rating_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_transaksi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
