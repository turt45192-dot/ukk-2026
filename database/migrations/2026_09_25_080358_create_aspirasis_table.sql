CREATE TABLE IF NOT EXISTS `aspirasis` (
    `id_aspirasi` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_kategori` INT UNSIGNED NOT NULL,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `foto` VARCHAR(255) NULL,
    `status` VARCHAR(50) DEFAULT 'Pending',
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;