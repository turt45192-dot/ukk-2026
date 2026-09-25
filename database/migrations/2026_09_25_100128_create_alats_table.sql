-- create_alat_table

CREATE TABLE IF NOT EXISTS `alat` (
    id_alat         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_alat       VARCHAR(255) NOT NULL,
    kode_alat       VARCHAR(10) NOT NULL UNIQUE,
    kondisi       VARCHAR(50) NOT NULL,
    jumlah         INT NOT NULL,
    lokasi         VARCHAR(255) NOT NULL, 
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;