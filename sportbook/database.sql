CREATE DATABASE IF NOT EXISTS sportbook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sportbook;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','member') DEFAULT 'member',
    status ENUM('active','banned') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_olahraga VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL,
    deskripsi TEXT,
    harga_per_jam DECIMAL(10,2) NOT NULL,
    foto VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    venue_id INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','rejected','cancelled') DEFAULT 'pending',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    metode VARCHAR(50),
    bukti_transfer VARCHAR(255),
    status ENUM('pending','verified','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    ip_address VARCHAR(45),
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE remember_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Default admin (password: Admin@123)
INSERT INTO users (nama, email, password, role) VALUES (
    'Administrator',
    'admin@sportbook.com',
    '$2y$10$TKh8H1.PfKBiVpKQn2QFxuKsNB2eMhJyHpqVb6wGx6J4pMuXqXfPq',
    'admin'
);

-- Sample venues
INSERT INTO venues (nama, jenis_olahraga, alamat, deskripsi, harga_per_jam) VALUES
('Lapangan Futsal A', 'Futsal', 'Jl. Merdeka No. 1', 'Lapangan futsal indoor standar', 100000),
('Lapangan Badminton B', 'Badminton', 'Jl. Sudirman No. 5', 'Lapangan badminton dengan lantai kayu', 75000),
('Lapangan Basket C', 'Basket', 'Jl. Gatot Subroto No. 10', 'Lapangan basket outdoor', 80000);
