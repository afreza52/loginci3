-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jul 2023 pada 06.57
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login-ci3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `img` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `img`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'Afreza Dwi Zuliyanto', 'admin@gmail.com', 'AFREZA_DWI_ZULIYANTO_(RPL).png', '$2y$10$sEdgcUdzmQtJNdzRFOMQge.X9sYfZmCYmt1cj2ElxHY5UrRqFVeKe', 1, 1, 1688719554),
(2, 'Faisa Anis Alfiatin', 'admein@gmail.com', 'FAISA_ANIS_ALFIATIN_(RPL).png', '$2y$10$9farPawUe3Pp2uHkw5ehGeTeslMZDqaNRuMJWVh.ReeJoPffHSmuK', 2, 1, 1688818113),
(3, 'Nezza Afifa Aulia', 'admqqn@gmail.com', 'NEZZA_AFIFA_AULIA_(RPL).png', '$2y$10$3wfv63bascXik0wO.vTtU.hTgr2eMF0Z7D6aTOOcSIK.DDAn0ZKG6', 2, 1, 1688956437),
(4, 'Afreza dwi zuliyanto1', 'adminn@gmail.com', 'default.png', '$2y$10$qIiUvoMkrVjcj4mRGhHouOYqb0.YbnEVvxSVk0Drcg8NVqli42jda', 2, 1, 1688959780),
(14, 'sukun', 'sukunn2000@gmail.com', 'default.png', '$2y$10$6qw5/q54ld/FRUoaio2vs.NUaZRCErGNibmVihJq4XbnRfvKl47Km', 2, 1, 1689570203),
(15, 'Afreza Dwi Zuliyanto', 'dwizuliyantoa@gmail.com', 'default.png', '$2y$10$mgSIXwbpDxCjbfzY3O3VK.VDelyOcRAaq4hxR.DhdvFP1S.d6n9ci', 2, NULL, 1689573198),
(16, 'sukun', 'sukunnn2000@gmail.com', 'default.png', '$2y$10$6rKIze8loBbyxQbrxJ.vQ.cYxlGNp9z8m.n7Dvqcg.en/mXiNAinC', 2, 1, 1689573760);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(8, 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, '1', 'Dashboard', 'admin', 'fa fa-fw fa-tachometer-alt', 1),
(2, '2', 'My Profile', 'user', 'fa fa-fw fa-user', 1),
(3, '2', 'Edit Profile', 'user/edit', 'fa fa-fw fa-user-edit', 1),
(4, '3', 'Menu Management', 'menu', 'fa fa-fw fa-folder', 1),
(5, '3', 'Submenu Management', 'menu/submenu', 'fa fa-fw fa-folder-open', 1),
(8, '1', 'Role', 'admin/role', 'fa fa-fw fa-user-tie', 1),
(9, '2', 'Change Password', 'user/changepassword', 'fa fa-fw fa-key', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(10, 'admin@gmail.com', 'KDCMffealpKyCWtv04h5zwLPkazoRed04sYdYtEA5fc=', 1689221623),
(11, 'admin@gmail.com', 'aAPtnGEB2gvdy+omkpuYD58AZzr2CG7QTVI4YJKnhjk=', 1689557119),
(12, 'admin@gmail.com', 'DE+IBJTBxeq2v8O9fdgXc/gY3uFHL3T81Zt2kpyDCfQ=', 1689559914),
(13, 'admin@gmail.com', 'gS1pv44RGYYY1E6AltnPu0ETkbfAzXW5B35O3KT3gYA=', 1689559958),
(14, 'admin@gmail.com', 'L4Bc7gdmE0wh4V8s6eEtTMm4f/iKqt1sEe2ejdJdytc=', 1689560004),
(15, 'admin@gmail.com', 'Ul8xUvKfh1j+kPw6i/m8EQ7vT8Zyqd49Iy7QE3aepLs=', 1689560070),
(16, 'admin@gmail.com', 'xuvBs89r+qEmwdir9iopsgF4U5MsiW2QEfUuwr3Iq0I=', 1689560565),
(17, 'admin@gmail.com', 'KdckV/lk+aP4XnQA2LOP2rjaCFt1TXL5TkGPqcyUUkE=', 1689561300),
(18, 'admin@gmail.com', 'OWEWDPqiaOxM5XF9o3wdgku9CjVu8JZEAuVfgmtz0l8=', 1689561568),
(21, 'admin@gmail.com', 'w4I25kMSg6C3FJtMJw1V8g3g6i8+GuqKXX1E0I40TOA=', 1689572607),
(22, 'sukunn2000@gmail.com', 'LCepT98ounKCqKKAZ142sBL3xOYX7ASPA5mgFBfeaWs=', 1689572625),
(23, 'sukunn2000@gmail.com', 'ORZ6FwmO/5bhm5Wyfsqu71dcf8PvKCZpV+JyVgPjz58=', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
