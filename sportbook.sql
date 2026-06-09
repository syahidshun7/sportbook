-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 07:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','rejected','cancelled') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `venue_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `total_harga`, `status`, `catatan`, `created_at`) VALUES
(1, 3, 1, '2026-06-06', '22:55:00', '23:55:00', 100000.00, 'confirmed', 'u', '2026-06-04 14:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `ip_address`, `attempted_at`) VALUES
(7, 'Lala@gmail.com', '::1', '2026-06-09 05:43:47'),
(8, 'adminbaru@sportbook.com', '::1', '2026-06-09 05:43:50'),
(9, 'adminbaru@sportbook.com', '::1', '2026-06-09 05:43:57'),
(10, 'adminbaru@sportbook.com', '::1', '2026-06-09 05:44:01'),
(11, 'adminbaru@sportbook.coma', '::1', '2026-06-09 05:44:03');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `metode`, `bukti_transfer`, `status`, `created_at`) VALUES
(1, 1, 'QRIS', 'payments/cff72184f1b13fe9e6a6842dc444f103.png', 'verified', '2026-06-04 14:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `status` enum('active','banned') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(2, 'Admin Baru', 'adminbaru@sportbook.com', '$2y$10$yklkww6we5KkVhKuNPRoguvtPykxwGH.t9.p7uV35abip/XQheRbe', 'admin', 'active', '2026-06-04 14:12:59'),
(3, 'Lala', 'Lala@gmail.com', '$2y$10$nrUnaX6lxpX2MDdN4OY8RezN7hgu6JKAL1SY3pbmR7PS5dQRpF5Ba', 'member', 'active', '2026-06-04 14:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_olahraga` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_jam` decimal(10,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `nama`, `jenis_olahraga`, `alamat`, `deskripsi`, `harga_per_jam`, `foto`, `status`, `created_at`) VALUES
(1, 'Lapangan Futsal 1', 'Futsal', 'Jl. Sudirman No. 12, Jakarta Pusat', 'Lapangan futsal indoor dengan lantai biru dan pencahayaan yang terang, cocok untuk latihan maupun pertandingan bersama teman dan tim.', 120000.00, 'venues/663839b0485960f41f143f038d1802cf.jpeg', 'active', '2026-06-04 13:34:42'),
(2, 'Lapangan Futsal 2', 'Futsal', 'Jl. Sudirman No. 5', 'Lapangan futsal indoor dengan desain modern dan suasana yang nyaman, ideal untuk bermain santai, latihan, maupun pertandingan.', 100000.00, 'venues/e5a2534678b2a75dab151ed77da23d08.jpeg', 'active', '2026-06-04 13:34:42'),
(3, 'Lapangan Badminton', 'Badminton', 'Jl. Gatot Subroto No. 10', 'Dilengkapi area bermain yang luas dan net standar, lapangan ini cocok digunakan untuk latihan maupun pertandingan badminton.', 75000.00, 'venues/6d3e6cb92241d914166b5499e50b2738.jpeg', 'active', '2026-06-04 13:34:42'),
(5, 'Lapangan Tenis', 'Tenis', 'Jl. Diponegoro No. 33', 'Lapangan tenis dengan permukaan yang nyaman digunakan untuk berbagai tingkat permainan, mulai dari latihan rutin hingga pertandingan. Dilengkapi garis lapangan yang jelas, net standar, serta area bermain yang luas sehingga pemain dapat bergerak dengan lebih leluasa dan fokus selama bermain.', 90000.00, 'venues/4fef6359dce28af9908a31d7c467cd18.jpeg', 'active', '2026-06-09 05:23:03'),
(6, 'Gym & Fitness', 'Fitness', 'Jl. Rajawali No. 9', 'Dilengkapi berbagai alat latihan kardio dan strength training, area gym ini memberikan ruang yang nyaman untuk berolahraga, menjaga kebugaran, dan mencapai target latihan dengan lebih optimal.', 30000.00, 'venues/6246a614570bbc551695d71b607d058b.jpeg', 'active', '2026-06-09 05:24:17'),
(7, 'Kolam Renang', 'Renang', 'Jl. Veteran No. 17', 'Nikmati pengalaman berenang yang nyaman di kolam renang yang terawat dengan area yang luas dan air yang jernih. Cocok untuk berolahraga, bersantai, maupun menghabiskan waktu bersama keluarga dan teman.', 45000.00, 'venues/722695387379d2ba7dffa53ae3a2e666.jpeg', 'active', '2026-06-09 05:26:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `remember_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
