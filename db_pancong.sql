-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 09 Jul 2025 pada 09.18
-- Versi server: 8.0.40
-- Versi PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pancong`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `addons`
--

CREATE TABLE `addons` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_addon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_addon` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `addons`
--

INSERT INTO `addons` (`id`, `nama_addon`, `harga_addon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Keju Cheddar', 3000.00, 1, '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(2, 'Milo', 4000.00, 1, '2025-06-24 23:35:45', '2025-07-09 06:51:13'),
(3, 'ChocoChip', 2500.00, 1, '2025-06-24 23:35:45', '2025-07-09 06:51:35'),
(4, 'Mesis', 2000.00, 1, '2025-06-24 23:35:45', '2025-07-09 06:51:57'),
(5, 'Choco Crunchy', 1500.00, 1, '2025-06-24 23:35:45', '2025-07-09 06:52:12'),
(9, 'Oreo Crumble', 3500.00, 1, '2025-06-24 23:35:45', '2025-06-24 23:35:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Pancong Original', '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(2, 'Pancong Manis', '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(3, 'Pancong Asin', '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(6, 'Pancong Spesial', '2025-07-09 02:44:09', '2025-07-09 02:44:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `custom_order_items`
--

CREATE TABLE `custom_order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `base_menu_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `addons_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL,
  `selected_addons` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `custom_order_items`
--

INSERT INTO `custom_order_items` (`id`, `order_id`, `base_menu_id`, `qty`, `base_price`, `addons_price`, `total_price`, `selected_addons`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 8000.00, 10000.00, 36000.00, '[{\"id\": 1, \"qty\": \"1\", \"nama_addon\": \"Keju Cheddar\", \"harga_addon\": \"3000.00\"}, {\"id\": 2, \"qty\": \"1\", \"nama_addon\": \"Coklat Nutella\", \"harga_addon\": \"4000.00\"}, {\"id\": 6, \"qty\": \"1\", \"nama_addon\": \"Mentega\", \"harga_addon\": \"1000.00\"}, {\"id\": 4, \"qty\": \"1\", \"nama_addon\": \"Susu Kental Manis\", \"harga_addon\": \"2000.00\"}]', '2025-06-25 02:01:31', '2025-06-25 02:01:31'),
(2, 2, 1, 1, 8000.00, 10000.00, 18000.00, '[{\"id\": 1, \"qty\": \"1\", \"nama_addon\": \"Keju Cheddar\", \"harga_addon\": \"3000.00\"}, {\"id\": 2, \"qty\": \"1\", \"nama_addon\": \"Coklat Nutella\", \"harga_addon\": \"4000.00\"}, {\"id\": 6, \"qty\": \"1\", \"nama_addon\": \"Mentega\", \"harga_addon\": \"1000.00\"}, {\"id\": 4, \"qty\": \"1\", \"nama_addon\": \"Susu Kental Manis\", \"harga_addon\": \"2000.00\"}]', '2025-06-25 09:40:46', '2025-06-25 09:40:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `galleries`
--

INSERT INTO `galleries` (`id`, `judul`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'foto-galleries/test.png', '2025-06-24 23:51:18', '2025-06-24 23:54:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id_item` bigint UNSIGNED NOT NULL,
  `nama_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id_item`, `nama_item`, `harga`, `gambar`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, 'Pancong Original', 8000.00, NULL, 1, '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(2, 'Pancong Keju', 12000.00, NULL, 3, '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(3, 'Pancong Coklat', 10000.00, NULL, 2, '2025-06-24 23:35:45', '2025-06-24 23:35:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_addons`
--

CREATE TABLE `menu_addons` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `addon_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2025_06_20_063634_create_galleries_table', 1),
(5, '2025_06_20_063644_create_addons_table', 1),
(6, '2025_06_20_063645_create_categories_table', 1),
(7, '2025_06_20_063646_create_menus_table', 1),
(8, '2025_06_20_063647_create_menu_addons_table', 1),
(9, '2025_06_20_065200_create_users_table', 1),
(10, '2025_06_20_065326_create_orders_table', 1),
(11, '2025_06_20_065335_create_order_items_table', 1),
(12, '2025_06_22_123006_create_custom_order_items_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `waktu_pesanan` date NOT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `no_meja` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Paid','Process','Ready','Done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id_pesanan`, `pelanggan_id`, `waktu_pesanan`, `total_harga`, `no_meja`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-06-25', 44000.00, 'B2', 'test', 'Done', '2025-06-25 02:01:31', '2025-06-25 09:14:29'),
(2, 2, '2025-06-25', 26000.00, 'B2', NULL, 'Done', '2025-06-25 09:40:46', '2025-07-09 06:52:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `qty` int DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `menu_id`, `order_id`, `qty`, `harga`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 8000.00, 8000.00, '2025-06-25 02:01:31', '2025-06-25 02:01:31'),
(2, 1, 2, 1, 8000.00, 8000.00, '2025-06-25 09:40:46', '2025-06-25 09:40:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_akun` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_akun`, `username`, `email`, `nama`, `no_telepon`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', 'Super Admin', '08123456789', 'admin', '$2y$12$S3AGDgOfQB7TTeJuARkKSuv9m15LPqd5KWBtAM4v5Vd/.VbHZbSei', NULL, '2025-06-24 23:35:45', '2025-06-24 23:35:45'),
(2, 'customer', 'customer@test.com', 'Customer Test', '08987654321', 'user', '$2y$12$OKJNB2b2SlcTxvZF08aKEu5xXNQitIBURlPW2HoqbD1.ayTcJvQqq', NULL, '2025-06-24 23:35:45', '2025-06-24 23:35:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `custom_order_items`
--
ALTER TABLE `custom_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_order_items_order_id_foreign` (`order_id`),
  ADD KEY `custom_order_items_base_menu_id_foreign` (`base_menu_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `menus_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `menu_addons`
--
ALTER TABLE `menu_addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_addons_menu_id_addon_id_unique` (`menu_id`,`addon_id`),
  ADD KEY `menu_addons_addon_id_foreign` (`addon_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `orders_pelanggan_id_foreign` (`pelanggan_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_menu_id_foreign` (`menu_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

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
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `custom_order_items`
--
ALTER TABLE `custom_order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id_item` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `menu_addons`
--
ALTER TABLE `menu_addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_pesanan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_akun` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `custom_order_items`
--
ALTER TABLE `custom_order_items`
  ADD CONSTRAINT `custom_order_items_base_menu_id_foreign` FOREIGN KEY (`base_menu_id`) REFERENCES `menus` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_pesanan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu_addons`
--
ALTER TABLE `menu_addons`
  ADD CONSTRAINT `menu_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_addons_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id_item`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id_akun`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
