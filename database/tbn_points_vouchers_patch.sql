-- =========================================================
-- TBN Laravel 13 - PATCH POINTS + VOUCHER + REWARD
-- Jalankan di phpMyAdmin pada database TBN.
-- Script dibuat idempotent: aman dijalankan ulang.
-- =========================================================
USE tbn;

SET @db = DATABASE();

-- 1. Kolom poin user
SET @sql = IF(
  (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=@db AND TABLE_NAME='users' AND COLUMN_NAME='points')=0,
  'ALTER TABLE users ADD COLUMN points INT UNSIGNED NOT NULL DEFAULT 0 AFTER profile_photo',
  'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 2. Riwayat poin
CREATE TABLE IF NOT EXISTS point_transactions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  points INT NOT NULL,
  type VARCHAR(40) NOT NULL,
  reference_type VARCHAR(100) NULL,
  reference_id BIGINT UNSIGNED NULL,
  description VARCHAR(255) NULL,
  balance_after INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  INDEX idx_points_user_created (user_id, created_at),
  CONSTRAINT fk_points_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Voucher WiFi / Koperasi
CREATE TABLE IF NOT EXISTS vouchers (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  type ENUM('wifi','koperasi') NOT NULL,
  code VARCHAR(100) NOT NULL UNIQUE,
  points_cost INT UNSIGNED NOT NULL,
  stock INT UNSIGNED NOT NULL DEFAULT 1,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  expires_at TIMESTAMP NULL DEFAULT NULL,
  description TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  INDEX idx_voucher_type_active (type, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Riwayat penukaran voucher
CREATE TABLE IF NOT EXISTS voucher_redemptions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  voucher_id BIGINT UNSIGNED NOT NULL,
  voucher_code VARCHAR(100) NOT NULL,
  points_spent INT UNSIGNED NOT NULL,
  status ENUM('Berhasil','Dibatalkan') NOT NULL DEFAULT 'Berhasil',
  redeemed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  INDEX idx_redemption_user_created (user_id, created_at),
  CONSTRAINT fk_redemption_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_redemption_voucher FOREIGN KEY (voucher_id) REFERENCES vouchers(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Voucher awal TBN
INSERT IGNORE INTO vouchers
(name, type, code, points_cost, stock, is_active, description, created_at, updated_at)
VALUES
('Voucher WiFi 1 Jam', 'wifi', 'WIFI-TBN-1JAM', 50, 10, 1, 'Voucher akses WiFi sekolah selama 1 jam.', NOW(), NOW()),
('Voucher Koperasi Rp10.000', 'koperasi', 'KOP-TBN-10K', 100, 10, 1, 'Voucher belanja koperasi sekolah senilai Rp10.000.', NOW(), NOW());

-- 6. Bonus poin dari foto yang sudah pernah masuk sebelum fitur poin aktif.
-- Baris ini hanya mengisi poin berdasarkan jumlah waste_records lama.
-- Jika tidak ingin memberikan bonus untuk data lama, hapus blok INSERT/UPDATE ini.
INSERT INTO point_transactions (user_id, points, type, reference_type, reference_id, description, balance_after, created_at, updated_at)
SELECT wr.user_id, 10, 'waste_photo', 'App\\Models\\WasteRecord', wr.id,
       'Bonus 10 poin dari upload foto sampah (data lama)', 0, wr.created_at, wr.updated_at
FROM waste_records wr
LEFT JOIN point_transactions pt
  ON pt.reference_type='App\\Models\\WasteRecord' AND pt.reference_id=wr.id AND pt.type='waste_photo'
WHERE pt.id IS NULL;

UPDATE users u
JOIN (
  SELECT user_id, SUM(points) AS total_points
  FROM point_transactions
  GROUP BY user_id
) x ON x.user_id=u.id
SET u.points=GREATEST(0,x.total_points);

-- Verifikasi
SELECT id, username, name, role, points FROM users ORDER BY id DESC;
SELECT id, name, type, code, points_cost, stock, is_active FROM vouchers ORDER BY id DESC;
