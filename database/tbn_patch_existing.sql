-- TBN Laravel 13 - Patch Database Existing
-- Jalankan pada database `tbn` yang SUDAH ADA.
USE `tbn`;

-- Normalisasi role lama.
UPDATE users SET role = 'Siswa' WHERE role IN ('USER', 'user', 'siswa');
UPDATE users SET role = 'Pengelola' WHERE role IN ('admin', 'ADMIN', 'pengelola');

-- Pastikan kolom profil tersedia pada database lama.
SET @has_nis := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'nis');
SET @sql := IF(@has_nis = 0, 'ALTER TABLE users ADD COLUMN nis VARCHAR(30) NULL AFTER email', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @has_class := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'class_name');
SET @sql := IF(@has_class = 0, 'ALTER TABLE users ADD COLUMN class_name VARCHAR(50) NULL AFTER nis', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @has_photo := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo');
SET @sql := IF(@has_photo = 0, 'ALTER TABLE users ADD COLUMN profile_photo VARCHAR(255) NULL AFTER class_name', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Akun demo lokal. Password: admin123 / siswa123.
UPDATE users SET password='$2y$12$PK8Z6locjclEZrWbOyRkqeea5QfXBHNTxT8xeFkt573KxB6OIq6tC', role='Pengelola', email_verified_at=COALESCE(email_verified_at, NOW()) WHERE email='admin@tbn.local';
UPDATE users SET password='$2y$12$PK8Z6locjclEZrWbOyRkqeea5QfXBHNTxT8xeFkt573KxB6OIq6tC', role='Pengelola', email_verified_at=COALESCE(email_verified_at, NOW()) WHERE email='pengelola@tbn.test';
UPDATE users SET password='$2y$12$RdD3oGViHb0do/37FQFFMuuMOancnJbZx65HJ7F.6UX/9AJ4P1mei', role='Siswa', class_name='XII RPL 2', email_verified_at=COALESCE(email_verified_at, NOW()) WHERE email='siswa@tbn.test';

-- Normalisasi akun siswa utama jika masih memakai role USER.
UPDATE users SET role='Siswa', class_name=COALESCE(class_name, 'XII RPL 2') WHERE username='RAMZIUSER';

SELECT id, username, email, role, class_name, email_verified_at FROM users ORDER BY id;
