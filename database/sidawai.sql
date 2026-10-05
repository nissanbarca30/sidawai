-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Okt 2026 pada 07.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sidawai`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'data_dukung',
  `tanggal` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `share_token` varchar(64) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `bulan_periode` varchar(255) NOT NULL,
  `tahun_periode` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2026_09_03_172335_add_nip_to_users_table', 1),
(7, '2026_09_04_012434_create_documents_table', 2),
(8, '2026_09_04_081900_add_kategori_to_documents_table', 3),
(9, '2026_09_04_091825_change_tanggal_column_in_documents_table', 4),
(10, '2026_09_07_024254_add_role_to_users_table', 5),
(11, '2026_09_15_034351_add_share_token_to_documents_table', 6),
(12, '2026_09_15_082544_add_permissions_to_users_table', 7),
(13, '2026_09_21_021620_create_settings_table', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('bawang.bombay707@gmail.com', '$2y$12$24AhdBDIZKTpafT2V0ZF5.qGLTzeXmHEWgWB87Fi.QtC7IRFNHOPa', '2026-09-14 19:01:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'allow_register', '0', '2026-09-20 19:17:26', '2026-09-24 20:36:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','pegawai') NOT NULL DEFAULT 'pegawai',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `name`, `email`, `role`, `permissions`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, '21082026', 'Admin 1', 'admin1@gmail.com', 'admin', '[\"access_dashboard\",\"manage_users\",\"manage_documents\"]', NULL, '$2y$12$azbuJYwysdAJsEVv6Aa.jOTJMvmsp55dcB9/alli8OhAwZbiuYxZC', NULL, '2026-09-03 10:36:46', '2026-10-01 00:13:53'),
(3, '20082026', 'Super Administrator', 'superadmin@unnamed.go.id', 'superadmin', NULL, NULL, '$2y$12$KQX1olYnCYE0j9GRoq0hv./fHycb4uDm6GLqHNc2JleFFwiIoBemK', NULL, '2026-09-06 19:57:14', '2026-10-01 00:13:09'),
(8, '197310071998031003', 'UMAR FAHMI, SKM, MKM', 'Umar.fahmi@kemkes.go.id', 'pegawai', NULL, NULL, '$2y$12$UrzRKfZDx7EFSsV9WOiwvudC2/176mHVnNEnRd8KvzS..GTW1QoQm', NULL, '2026-09-30 21:24:47', '2026-09-30 21:24:47'),
(9, '197006221995011001', 'CHRISMAN LECLAZES JUNIARA SINGARIMBUN, SKM, M.Kes', 'singarimbunchrisman@gmail.com', 'pegawai', NULL, NULL, '$2y$12$fYQAXtWut68yuBut7o9Ir.Yo/SLmUTwYga3TTbUUhLYyYOkrr9OBi', NULL, '2026-09-30 21:27:19', '2026-09-30 21:27:19'),
(10, '196709291990031004', 'SUTRISNO, S.IP, M.Si., M.Kes.', 'arunazsapnk@gmail.com', 'pegawai', NULL, NULL, '$2y$12$vd1xhxM.QEWSLTG371kRjeLwBwLN4jFyDCcl0Fio7qYZqll5r2Jxi', NULL, '2026-09-30 21:28:05', '2026-09-30 21:28:05'),
(11, '197307201992022001', 'BIBI ZARINA, SKM, M.Kes', 'huseinbina@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Irz7/SVsEtpBX6b3.Tj1Kud7LKMjjO8MkwOmExjY1CNZRQycyLkTa', NULL, '2026-09-30 21:31:35', '2026-09-30 21:31:35'),
(12, '197202112006042005', 'LILI LUSIANA, SKM, M.Si', 'lilimatondang432@gmail.com', 'pegawai', NULL, NULL, '$2y$12$VJIP5PeSq49U2c6vYVWqtuHsp9TtXKKYgyZXOHXSejYv3uZFNHeZW', NULL, '2026-09-30 21:32:10', '2026-10-01 00:09:40'),
(13, '198101192008122001', 'KIBLAT PUSPA VIJAYA, M.K.K.', 'kiblatpuspavijaya@gmail.com', 'pegawai', NULL, NULL, '$2y$12$OqDsxMIl.eSU5rHByFi03.ekAuLx8S2RoSgnqeRB5PfSa1CGmB..C', NULL, '2026-09-30 21:32:51', '2026-09-30 21:34:34'),
(14, '198207082010121002', 'ANDY GUNAWAN PASARIBU', 'andygunawanp57@gmail.com', 'pegawai', NULL, NULL, '$2y$12$jZMqDVsosY9qbv5tQ2o3ZeAy4VY/jaCKCV5yHhSa5acJstBaP6wTu', NULL, '2026-09-30 21:33:22', '2026-10-01 00:04:29'),
(15, '197708252010122002', 'RIRI FATMA', 'ririf25@gmail.com', 'pegawai', NULL, NULL, '$2y$12$.I6dLq/bF7Tj0rYJhK.uae24i7EN3oU9vJglsP7f6w31qsZQ7EkwO', NULL, '2026-09-30 21:34:14', '2026-09-30 21:34:14'),
(16, '196905151990031003', 'SAMHUDI, SH', 'endysome4848@gmail.com', 'pegawai', NULL, NULL, '$2y$12$LZGkvp1x70YYcsWAeECmwez6VOROG5XCZZNQjp6UaEfgitWeOSDFG', NULL, '2026-09-30 21:35:15', '2026-09-30 21:35:15'),
(17, '198601092008012005', 'DEWI PURNAMA SARI, SKM', 'sari.kkp.pontianak@gmail.com', 'pegawai', NULL, NULL, '$2y$12$tf4eMZZv2XZHuAtVU5Ed0.yxItqB7Zt5.0uD3BABF58A153VCMLAe', NULL, '2026-09-30 21:35:45', '2026-09-30 21:35:45'),
(18, '198412122010121001', 'ABRAHAM TINODO, S.Kom', 'tinodosihombing@gmail.com', 'pegawai', NULL, NULL, '$2y$12$kXrEtQx4/nyliHHPB3EztODyxsS7bpBmHnn5FjZApKLbMWwrjahxy', NULL, '2026-09-30 23:17:36', '2026-09-30 23:17:36'),
(19, '198001062005011002', 'TOTOK SUTIANTO, S.ST, M.Epid.', 'alwaystotoke@gmail.com', 'pegawai', NULL, NULL, '$2y$12$xZ3XR9nGddWGFKxeFy0MC.UDLceZBs.khIR3kSbcafnkyHoIHyLYG', NULL, '2026-09-30 23:18:24', '2026-09-30 23:18:24'),
(20, '197510111998032001', 'RIKA, SKM', 'rika98kkp@gmail.com', 'pegawai', NULL, NULL, '$2y$12$gHMYR9BF1qqhWPizET.pWe46kRYnnwaaTiJVImY7V0KNor8.JALhu', NULL, '2026-09-30 23:18:50', '2026-09-30 23:18:50'),
(21, '197607081999032002', 'YULIASRI, S.Kep, Ners', 'yuliasriyuliasri7@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Sp0ELn4jWZqDBFo/Bw3/Fu.VHCg7QWhlqZS0vZPh6bfn2a/Om/MHG', NULL, '2026-09-30 23:19:29', '2026-09-30 23:19:29'),
(22, '199104102018012001', 'SISKA SITUMORANG', 'drsiskasitumorang@gmail.com', 'pegawai', NULL, NULL, '$2y$12$D1NKrrdUTkg2rKpc0lkwLOWgN3NeaDqZcQkhb7OuORu09kMBlAmxu', NULL, '2026-09-30 23:20:10', '2026-09-30 23:20:10'),
(23, '197711152005012001', 'NELLY VERAWATI, SKM, M.Kes', 'nverawati77@gmail.com', 'pegawai', NULL, NULL, '$2y$12$6GQRDnXGaa2MoKBgpQqmaeJtaONATh.gszTRCb0CswjCbaQvirOSa', NULL, '2026-09-30 23:21:01', '2026-09-30 23:21:01'),
(24, '197805082000031003', 'SUHARNO, SKM', 'emailharno@gmail.com', 'pegawai', NULL, NULL, '$2y$12$qXbuuulcRcDoJpXkB2b1wO5q4yidy4o/WklEyyx2qDNealii1UMZm', NULL, '2026-09-30 23:21:32', '2026-09-30 23:21:32'),
(25, '198106012005012003', 'NUZZILA RAHMA', 'nuzzilarahma@gmil.com', 'pegawai', NULL, NULL, '$2y$12$HtspkYloG8O7/hwDWzKGr.knL7ulZQrLCiY2i64xZHIK3lMcqP19a', NULL, '2026-09-30 23:22:04', '2026-09-30 23:22:04'),
(26, '198312252005012002', 'TRI MAULINA', 'trimaulina251283@gmail.com', 'pegawai', NULL, NULL, '$2y$12$ulsSZFTmZGDBAY5aJ4fiIuexFZCKsuiHuSlOWvK53jMhpxPVPj4RG', NULL, '2026-09-30 23:22:34', '2026-09-30 23:22:34'),
(27, '198008032006041002', 'BUNGARAN, S. ST', 'bungaran.3880@gmail.com', 'pegawai', NULL, NULL, '$2y$12$JplEURi.Yz5ONKfravMWluKQnZ1SZgHsXkvbnn0OjGVyEz8beWi1.', NULL, '2026-09-30 23:23:09', '2026-09-30 23:23:09'),
(28, '197809152006042003', 'SILVIANY, Amd. f', 'silvianypadelvi@gmail.com', 'pegawai', NULL, NULL, '$2y$12$BetiHGjfGlMn.Gg/l7vsU.64vlp3t1rK1a1PHHcQnE8crxW/x4xdO', NULL, '2026-09-30 23:23:39', '2026-09-30 23:23:39'),
(29, '198202072005012007', 'EMI UTAMI, SKM', 'bilhusna82@gmail.com', 'pegawai', NULL, NULL, '$2y$12$rX8H3NuMIDZalCCuqZcfu.cv68EjRk9pKP1hBikdbqXfxqtRw4xpW', NULL, '2026-09-30 23:24:18', '2026-09-30 23:24:18'),
(30, '197408032005012001', 'UTAMI', 'utamibiasa@gmail.com', 'pegawai', NULL, NULL, '$2y$12$lAIwZxvzolAe.iGA/nMv5.yqcfiLRNLdDfbC5PS4pCz0il15UeZn6', NULL, '2026-09-30 23:24:49', '2026-10-01 00:10:22'),
(31, '197612022006042001', 'YUYUN DARMAWATI, SKM', 'yuyun1976.yd@gmail.com', 'pegawai', NULL, NULL, '$2y$12$rlGiDTic050JLcxFXHwMPuQJER5YnRdhOMtwg67HiRcqTCbWoNJvC', NULL, '2026-09-30 23:25:22', '2026-09-30 23:25:22'),
(32, '198208232006041002', 'HARYS TRI LAKSANA, SKM', 'harys.tri@gmail.com', 'pegawai', NULL, NULL, '$2y$12$ay9pdLnL3WnIT43DUME83.pM5UP6JOYOoV.x1OYGVwza.lW5JkN2e', NULL, '2026-09-30 23:25:52', '2026-09-30 23:25:52'),
(33, '198307282014022001', 'KRISTIAN EKO SETIARINI, SKM', 'kesetiarini@gmail.com', 'pegawai', NULL, NULL, '$2y$12$YbppDCDKTyoJP/yztnQXjufBHISRBYgO1EEckpvZskzjcIUzSPDMS', NULL, '2026-09-30 23:26:23', '2026-09-30 23:26:23'),
(34, '199105162015032002', 'MEKANITA, SE', 'mekanita16@gmail.com', 'pegawai', NULL, NULL, '$2y$12$FbvKVzdkoMTlptSONd43h.ghi57rTjqrIzQzOi5oDDt0Kks5Kvdfe', NULL, '2026-09-30 23:31:06', '2026-09-30 23:31:06'),
(35, '198309162007012003', 'SYARIFAH MARYANI', 'syarifahmaryani85@gmail.com', 'pegawai', NULL, NULL, '$2y$12$oNgOgJzsC15t3Rpyl5cVzuh5JMh6DCzeh4AnLLevSrbwfjrXC8IiO', NULL, '2026-09-30 23:31:52', '2026-09-30 23:31:52'),
(36, '198701092008012004', 'LINA NOVIASARI, A.Md.Kep', 'linalaga09@gmail.com', 'pegawai', NULL, NULL, '$2y$12$VTxC/4VL2yoQURSNeOz6D.O6fCVzZ55iHxb8BjUUUXgOeEhx5q.hS', NULL, '2026-09-30 23:32:40', '2026-09-30 23:32:40'),
(37, '198003282008011013', 'ADI WIJAYANTO, SST', 'adi.kkp.pontianak@gmail.com', 'pegawai', NULL, NULL, '$2y$12$KK5qGo/j.HKQpj4UqH6nR.KgF/3Pm0qpGOFNj7gdRccDhHLHMJoWq', NULL, '2026-09-30 23:34:50', '2026-09-30 23:34:50'),
(38, '198206272005012002', 'NENENG ROSNAWATI, S.K.M', 'nenengrosnawati15@gmail.com', 'pegawai', NULL, NULL, '$2y$12$7Hs9WG3tEtmtVi.apAHYcetRwTPbRm5CsDCRXnUUEHv6CFpefFkWC', NULL, '2026-09-30 23:35:22', '2026-09-30 23:35:22'),
(39, '198707042008121001', 'FELLIANDRE MARAFELINO, SKM', 'felliandre@gmail.com', 'pegawai', NULL, NULL, '$2y$12$MoIw6gbym18Kwhq.YgQUre/40m59FB10XUyJz8TlOJ.W/Mdtiqzsq', NULL, '2026-09-30 23:37:09', '2026-09-30 23:37:09'),
(40, '196811271992031010', 'SISWANTO', 'siswanto27111968@gmail.com', 'pegawai', NULL, NULL, '$2y$12$lFjKxwKZgcN544MQNaKFeOHx5QQbCWGxXxUj4o8cxO.vWvmLcFZLe', NULL, '2026-09-30 23:37:41', '2026-09-30 23:37:41'),
(41, '197307111994031003', 'KASIUS, S.A.P.', 'kasiuskkp@gmail.com', 'pegawai', NULL, NULL, '$2y$12$c.Icca9IdFJZdest5GC3aON7JJM6TRSx.eqNTr02Pqvy/YoA1rqoy', NULL, '2026-09-30 23:38:25', '2026-09-30 23:38:25'),
(42, '197101011997031006', 'MUJI UTOMO', 'mujiutomo1971@gmail.com', 'pegawai', NULL, NULL, '$2y$12$HBLWO4gNDFOQM1W17/TS1eFF9S.dT9VUTeJp9JY2WlJqMGSoyMYp6', NULL, '2026-09-30 23:38:56', '2026-09-30 23:38:56'),
(43, '198706162008121002', 'RHEZKA IMANIAR FITRANTO, SKM', 'rhezka@gmail.com', 'pegawai', NULL, NULL, '$2y$12$pvGK883FHSKNCDIfn9ogo.YI.EVUFCr01NmQf9LSoZbV/qpdYE/JG', NULL, '2026-09-30 23:39:26', '2026-09-30 23:39:26'),
(44, '\'199306142022031002', 'MUHAMMAD HADI ARWANI', 'hadiarwani@gmail.com', 'pegawai', NULL, NULL, '$2y$12$mo.BXnnRb03/C0FjWkR8Ou6ET.9z2e0uXI2EI0KHQpAqo/VEgFq3i', NULL, '2026-09-30 23:39:56', '2026-09-30 23:39:56'),
(45, '198911242009121001', 'EKKY FAJAR FRANA, SKM', 'ekkyfajarfrana@gmail.com', 'pegawai', NULL, NULL, '$2y$12$6aymcxL0vJ1POXmtOGa2Se0polAzcwoPjEplMt6SHs1tjHp2BG7uy', NULL, '2026-09-30 23:40:29', '2026-09-30 23:40:29'),
(46, '199406172020122010', 'YUNIKE FRASISCA NONGKANG, S.Kep., Ns', 'yunike.frasisca@gmail.com', 'pegawai', NULL, NULL, '$2y$12$XdipCj4cIPD1pwcxixG06e0wqDUqR0lONhTjLrFK7D7mrmCMDxQW6', NULL, '2026-09-30 23:41:10', '2026-09-30 23:41:10'),
(47, '199501202019022001', 'DIAN SARI PUTRI, SKM', 'diansariputri0@gmail.com', 'pegawai', NULL, NULL, '$2y$12$0U8JYxNA.P11eEgcpIpdNeGlPAy9vdlFYbDFe7ZFgcnBUWHuKV6dO', NULL, '2026-09-30 23:41:44', '2026-09-30 23:41:44'),
(48, '198906162012121001', 'ZAINUL AMBIYA, SKM', 'zainul.ambiya88@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Z5V2V8Oz7nAGxM//HRLx/uF7CNFrVb6gdMa.riLSySRvAO3wAek.O', NULL, '2026-09-30 23:42:20', '2026-09-30 23:42:20'),
(49, '199607272025061009', 'MUHAMMAD FADHIL AMRULLAH', 'fadhil149@gmail.com', 'pegawai', NULL, NULL, '$2y$12$C6bat56ScmnkSKLJM1iuee0etH3Il1N420wy9H5QE3kXiHXVugeyK', NULL, '2026-09-30 23:43:06', '2026-09-30 23:43:06'),
(50, '198807272020121002', 'BENEDIKTUS BENY, S.Kom', 'benykkpkls2ptk@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Dn4MoABw8Emxq9l27WncFud/LU5bm922xMDn46eYoOLwg7wH2HXW.', NULL, '2026-09-30 23:43:40', '2026-09-30 23:43:40'),
(51, '197903032006041021', 'DEDE MARTIN KURNIAWAN, S.A.P.', 'dedemartin14@yahoo.com', 'pegawai', NULL, NULL, '$2y$12$CkIGcofm.1ga6VAakpDA5ugKdU4evJWXtpNsoAq37N7S1Y1s8ZlJq', NULL, '2026-09-30 23:44:18', '2026-09-30 23:44:18'),
(52, '198301142012122001', 'DIYAN EKOWATI, Amd.KL', 'diyanekowati@gmail.com', 'pegawai', NULL, NULL, '$2y$12$H5t35d93kFBEKzAic0G0nO7Q8D6NA1pMkqb8C/ArA//NJW.wJGrY6', NULL, '2026-09-30 23:44:58', '2026-09-30 23:44:58'),
(53, '199108112012121001', 'ABINAWA ASOTJA, S.Tr.Kes', 'abinawaasotja@gmail.com', 'pegawai', NULL, NULL, '$2y$12$FHC5J0mmEqSQYZxSvs4j5eeNv0fGAtKwAmUJCkyb97Zm1IYM.4Zvm', NULL, '2026-09-30 23:45:39', '2026-09-30 23:45:39'),
(54, '199203242014022002', 'BRIGITA DWITA ANTA LINI, A.Md.KL', 'brigitadwita@gmail.com', 'pegawai', NULL, NULL, '$2y$12$iCbi11UM.9yLbCmNzEKf9.7/iC9Y4N05sp8XsP1AuGItaN3z75xv2', NULL, '2026-09-30 23:46:23', '2026-09-30 23:46:23'),
(55, '198007102007011018', 'JUNAIDI, A.Md.Kep', '4bikhaira@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Ku6/FPNBYizIHbxuPUN/dOyVbC8l9sPhCEHKMXh6o1mc4w/NWPSt6', NULL, '2026-09-30 23:47:02', '2026-09-30 23:47:02'),
(56, '199802232025062006', 'PUTRI ARYANI, S.I.Kom.', 'putri.shereen@gmail.com', 'pegawai', NULL, NULL, '$2y$12$HNecvOLSNyL2aWCqnUCoX.IqxBv9Hj7KdwyQYVXm2mMEiUSsYiqby', NULL, '2026-09-30 23:47:37', '2026-09-30 23:47:37'),
(57, '198210302014122003', 'UTIN ENNY MAHARANI, S.M.', 'Utinenny@gmail.com', 'pegawai', NULL, NULL, '$2y$12$S0y2Y03wuypRaWLFTxKwTeDLKUdBNbS06sZtvnmD5VrzwOiv1mLSS', NULL, '2026-09-30 23:48:26', '2026-09-30 23:48:26'),
(58, '199310282018011001', 'FARIS ANDRIANTO', 'farisandrianto793@gmail.com', 'pegawai', NULL, NULL, '$2y$12$4wSVHDkD8VeQCYah.OEq3enU9PL0DJwreHXUirv85JvmuXkST3CwW', NULL, '2026-09-30 23:48:55', '2026-09-30 23:48:55'),
(59, '198412072008122002', 'DEWI HANDAYANI', 'dewi84.kkppontianak@gmail.com', 'pegawai', NULL, NULL, '$2y$12$9yWdIjPtpeOGcD4QZEQnheajBffiNtg7otiAxvGu2eAO4jqxlWsVy', NULL, '2026-09-30 23:49:23', '2026-09-30 23:49:23'),
(60, '199103042020121006', 'SULINDAR ANDRYADMA, A.Md.Kep', 'im.gud.male@gmail.com', 'pegawai', NULL, NULL, '$2y$12$.qjpcXxVclmycCWvPRDsd.iSEJ36Tz9ujhT0elZ7jap9eN6M0MLwG', NULL, '2026-09-30 23:49:55', '2026-09-30 23:49:55'),
(61, '199110042022031002', 'OKTAFIYAN PRIHADI KUSUMA', 'oktafiyan.p.kusuma@gmail.com', 'pegawai', NULL, NULL, '$2y$12$m4p9/HCxxLZ42UkXja2iOOQr1R1YtD8JCTqL/Mlcp8/3E.3TLq4XK', NULL, '2026-09-30 23:50:26', '2026-09-30 23:50:26'),
(62, '199308252022032001', 'PUTRI PRATIWININGRUM', 'putripratiwi.2593@gmail.com', 'pegawai', NULL, NULL, '$2y$12$dLEmKBXSRRYkcRTvW5vye.Y9N2H8tbnoXfs3A4/nURmGFX/S.FdG.', NULL, '2026-09-30 23:50:54', '2026-09-30 23:50:54'),
(63, '199705102022031001', 'RASMI ASSIDDIQI', 'kkp.diqi@gmail.com', 'pegawai', NULL, NULL, '$2y$12$napjM7xPrM/mxEhaY4sEruuCOYBnnoEq/swKUykIDr5NlOBoUxwL2', NULL, '2026-09-30 23:51:25', '2026-09-30 23:51:25'),
(64, '198109212014121001', 'EKO KURNIAWAN', 'ekoasus0107@gmail.com', 'pegawai', NULL, NULL, '$2y$12$uTYUTAEN6/lagk7nXV7N/uNORsBGG6F8NlviWU8CTtxX1FESx1CN2', NULL, '2026-09-30 23:51:56', '2026-09-30 23:51:56'),
(65, '200008052025062005', 'AFIFAH NOURIA AGUSTINA ARIYANTI, A.Md.Kes', 'afifahnori08@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Ejnv7Z5SNlhNrahD6f.LFegTSaISjN2WOEaqUsnReyITcNa9SnngK', NULL, '2026-09-30 23:52:25', '2026-09-30 23:52:25'),
(66, '198309152024211011', 'RONI, S.Farm.', 'ronikece@gmail.com', 'pegawai', NULL, NULL, '$2y$12$CoWqLXmG4NoVBBw5DGEp/eEs3CpMbn5uDoFRPnbrxqPCQWFjbdpNy', NULL, '2026-09-30 23:55:45', '2026-09-30 23:55:45'),
(67, '198511272025211022', 'ZEFFRY, S.Kom', 'foxzeer@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Zu5l2WNQNyMzkCwiHa8Npex3ptkRJxSJKCm/46pwd9NKXhNWv3mam', NULL, '2026-09-30 23:56:20', '2026-09-30 23:56:20'),
(68, '199012122025211099', 'EKO HADMA DEWANTARA, S.ST', 'ekoh860@gmail.com', 'pegawai', NULL, NULL, '$2y$12$sWQanvAUaVf59MUiCfzv3Ozwj/0MEsT8QBvyJQFhz9jDe8tw1Dvbq', NULL, '2026-09-30 23:56:49', '2026-09-30 23:56:49'),
(69, '199612232025212045', 'ANNISA SUHARNI, S.Ak', 'annisasuharni.as.as@gmail.com', 'pegawai', NULL, NULL, '$2y$12$5Iv..petq0.tvnzbsvDmz.DTsjWAmkGL8ilzFW7L1fV1rwq8vrkoC', NULL, '2026-09-30 23:57:17', '2026-09-30 23:57:17'),
(70, '199810292025212016', 'WINDI SAKYLA, S.Tr.Ak', 'wsakyla8@gmail.com', 'pegawai', NULL, NULL, '$2y$12$0iIbsz.tuay7XrWWD0ftH.mm05YBkV2JVKZ1H77oLtCsS1TEO1ihC', NULL, '2026-09-30 23:57:51', '2026-09-30 23:57:51'),
(71, '199512052024211018', 'ADE GUNAWAN', 'adeegunawaan@gmail.com', 'pegawai', NULL, NULL, '$2y$12$Jnz4kvgGHcKkT/PpsIk48.ZvP2GTybE7Tzl3umC.g.2XbyAv0k0wy', NULL, '2026-09-30 23:58:23', '2026-09-30 23:58:23'),
(72, '199207222025211051', 'ERWIN KURNIAWAN, A.Md.Kep', 'rwinblazee92@gmail.com', 'pegawai', NULL, NULL, '$2y$12$g3YvsfxYT41IjzFx0QF1BecmrUe1jzXYPmG9grpfAJHZrkw0wsCt.', NULL, '2026-09-30 23:58:55', '2026-09-30 23:58:55'),
(73, '199402252025211053', 'WILLIANUS DEO, A.Md.Kep.', 'deotatto1@gmail.com', 'pegawai', NULL, NULL, '$2y$12$YMDxZV75uBDp2Gaw0ONCF.3H3Q3rteAvaqJE2Kr2EQrbQXhNZtPrq', NULL, '2026-09-30 23:59:28', '2026-09-30 23:59:28'),
(74, '199403182025211038', 'RANDI RUSTIAWAN, A.md.KL', 'rustiawanrandi@gmail.com', 'pegawai', NULL, NULL, '$2y$12$f7zniKk6FrLqW5bW4FQEBuJmLbFL0c7fuL2j1GadGtKqyOXF64UV.', NULL, '2026-09-30 23:59:56', '2026-09-30 23:59:56'),
(75, '200007082025211018', 'ZAHRUL ADITYADARMA A. MOKA', 'adityaamoka8@gmail.com', 'pegawai', NULL, NULL, '$2y$12$XhamA5N334BdnL/uDCWmJuWxgwRdwixd.4orUZHXSb4/smhEbA8SG', NULL, '2026-10-01 00:00:25', '2026-10-01 00:00:25'),
(76, '22082026', 'Admin 2', 'admin2@gmail.com', 'admin', NULL, NULL, '$2y$12$4j.uBYPlMltCftGIKz.mPO1ouDZzUzqbfxddAdNaJMwmlyALwOis.', NULL, '2026-10-01 00:13:43', '2026-10-01 00:13:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_share_token_unique` (`share_token`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
