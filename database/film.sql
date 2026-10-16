CREATE DATABASE IF NOT EXISTS film_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE film_db;

CREATE TABLE IF NOT EXISTS film (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  sutradara VARCHAR(100) NOT NULL,
  genre VARCHAR(50) NOT NULL,
  tahun_rilis SMALLINT NOT NULL,
  durasi SMALLINT NOT NULL,
  rating DECIMAL(3,1) NOT NULL DEFAULT 0.0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO film (judul, sutradara, genre, tahun_rilis, durasi, rating) VALUES
('Inception', 'Christopher Nolan', 'Sci-Fi', 2010, 148, 8.8),
('Parasite', 'Bong Joon-ho', 'Thriller', 2019, 132, 8.5),
('Laskar Pelangi', 'Riri Riza', 'Drama', 2008, 125, 7.8);