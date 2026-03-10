-- Database: raaster_shuttel
-- Create database
CREATE DATABASE IF NOT EXISTS `raaster_shuttel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `raaster_shuttel`;
SET FOREIGN_KEY_CHECKS=0;

-- 1. USERS & AUTH
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'customer', 'driver') NOT NULL,
  `phone` VARCHAR(20),
  `address` TEXT,
  `photo_profile` VARCHAR(255) DEFAULT 'default.png',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `customer_detail` (
  `user_id` INT(11) NOT NULL,
  `nik` VARCHAR(20),
  `gender` ENUM('L','P'),
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `driver_detail` (
  `user_id` INT(11) NOT NULL,
  `no_sim` VARCHAR(50),
  `status_driver` ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
  `gaji_per_trip` DECIMAL(10,2) DEFAULT 50000.00,
  `current_armada_id` INT(11) NULL,
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. OPERATIONAL DATA
CREATE TABLE IF NOT EXISTS `armada` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_armada` VARCHAR(50) NOT NULL,
  `plat_nomor` VARCHAR(20) NOT NULL,
  `kapasitas` INT(11) NOT NULL DEFAULT 8,
  `layout_kursi` VARCHAR(50) DEFAULT '1-3-4', -- For rendering logic
  `status` ENUM('tersedia', 'maintenance', 'jalan') DEFAULT 'tersedia',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `kursi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `armada_id` INT(11) NOT NULL,
  `nomor_kursi` VARCHAR(10) NOT NULL, -- e.g., '1A', '1B'
  PRIMARY KEY (`id`),
  FOREIGN KEY (`armada_id`) REFERENCES `armada`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rute` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kota_asal` VARCHAR(50) NOT NULL,
  `kota_tujuan` VARCHAR(50) NOT NULL,
  `harga` DECIMAL(10,2) NOT NULL,
  `estimasi_waktu` VARCHAR(20), -- e.g., '3 Jam'
  `jarak_km` INT(11),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jadwal` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `rute_id` INT(11) NOT NULL,
  `jam_berangkat` TIME NOT NULL,
  `hari_aktif` TEXT, -- JSON e.g., ["Senin", "Selasa"] or "All"
  `status` ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`rute_id`) REFERENCES `rute`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TRANSACTIONS & TRIPS
CREATE TABLE IF NOT EXISTS `perjalanan` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `jadwal_id` INT(11) NOT NULL,
  `armada_id` INT(11), -- Assigned explicitly or blank initially
  `driver_id` INT(11), -- Assigned driver
  `tanggal` DATE NOT NULL,
  `status` ENUM('dijadwalkan', 'menjemput', 'dalam_perjalanan', 'selesai', 'batal') DEFAULT 'dijadwalkan',
  `jam_mulai` DATETIME,
  `jam_selesai` DATETIME,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal`(`id`),
  FOREIGN KEY (`armada_id`) REFERENCES `armada`(`id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id` VARCHAR(20) NOT NULL, -- Custom Order ID e.g., TRx123
  `customer_id` INT(11) NOT NULL,
  `perjalanan_id` INT(11) NOT NULL,
  `tanggal_pemesanan` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `total_harga` DECIMAL(10,2) NOT NULL,
  `status_pembayaran` ENUM('pending', 'lunas', 'batal', 'refund') DEFAULT 'pending',
  `metode_pembayaran` VARCHAR(20),
  `bukti_bayar` VARCHAR(255),
  `titik_jemput_lat` VARCHAR(20),
  `titik_jemput_lng` VARCHAR(20),
  `alamat_jemput` TEXT,
  `catatan` TEXT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`perjalanan_id`) REFERENCES `perjalanan`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pemesanan_seat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pemesanan_id` VARCHAR(20) NOT NULL,
  `kursi_id` INT(11), -- Reference to master kursi if needed, or just string if loose
  `nomor_kursi` VARCHAR(10) NOT NULL,
  `nama_penumpang` VARCHAR(100),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `qr_ticket` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pemesanan_id` VARCHAR(20) NOT NULL,
  `qr_code_path` VARCHAR(255) NOT NULL,
  `is_scanned` TINYINT(1) DEFAULT 0,
  `scanned_at` DATETIME,
  `scanned_by` INT(11), -- Driver ID
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. FINANCE & REPORTS
CREATE TABLE IF NOT EXISTS `pembayaran_customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `pemesanan_id` VARCHAR(20) NOT NULL,
  `jumlah` DECIMAL(10,2) NOT NULL,
  `tanggal_bayar` DATETIME,
  `status` ENUM('valid', 'invalid') DEFAULT 'valid',
  `admin_id` INT(11), -- Who validated
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pemesanan_id`) REFERENCES `pemesanan`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pembayaran_driver` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `driver_id` INT(11) NOT NULL,
  `periode_mulai` DATE NOT NULL,
  `periode_akhir` DATE NOT NULL,
  `total_trip` INT(11) DEFAULT 0,
  `total_pp` INT(11) DEFAULT 0, -- Pulang Pergi calculation
  `total_gaji` DECIMAL(10,2) NOT NULL,
  `total_bonus` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'dibayar') DEFAULT 'pending',
  `tanggal_dibayar` DATETIME,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. FEATURES
CREATE TABLE IF NOT EXISTS `chat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender_id` INT(11) NOT NULL,
  `receiver_id` INT(11) NOT NULL,
  `message` TEXT NOT NULL,
  `attachment` VARCHAR(255),
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`receiver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(100),
  `message` TEXT,
  `link` VARCHAR(255),
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `keluhan_saran` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `driver_id` INT(11), -- Optional targeted driver
  `perjalanan_id` INT(11), -- Optional related trip
  `subject` VARCHAR(100),
  `isi` TEXT,
  `status` ENUM('open', 'responded', 'closed') DEFAULT 'open',
  `balasan` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`perjalanan_id`) REFERENCES `perjalanan`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `berita` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(255),
  `konten` LONGTEXT,
  `gambar` VARCHAR(255),
  `tanggal_posting` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `author_id` INT(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DEFAULT DATA
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES 
('Admin Raaster', 'admin@raaster.com', '$2y$10$X...HashedPasswordHere...', 'admin');

SET FOREIGN_KEY_CHECKS=1;
