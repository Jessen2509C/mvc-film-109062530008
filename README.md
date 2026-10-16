# MVC PHP Native - Data Film

Aplikasi CRUD sederhana untuk mengelola data film, dibuat untuk mempelajari
pola Model-View-Controller pada PHP Native dengan PDO dan workflow Git.

## Kebutuhan

- PHP 8.1 atau lebih baru
- MySQL/MariaDB
- Web server lokal seperti XAMPP atau Laragon
- Git

## Instalasi

1. Clone atau salin project ke folder web server (`htdocs` untuk XAMPP, `www` untuk Laragon).
2. Import `database/film.sql` melalui phpMyAdmin, atau lewat terminal:
   `mysql -u root -p < database/film.sql`
3. Sesuaikan username dan password pada `config/database.php`.
4. Buka `http://localhost/mvc-film/public/index.php`.

## Struktur MVC

- `app/models/` : akses dan operasi data (`Film.php`).
- `app/controllers/` : alur request dan validasi (`FilmController.php`).
- `app/views/film/` : tampilan HTML (`index`, `create`, `edit`).
- `config/` : konfigurasi koneksi database PDO.
- `database/` : skema dan data awal SQL.
- `public/` : entry point dan router sederhana.

## Entitas Film

| Atribut     | Tipe         | Keterangan                            |
| ----------- | ------------ | ------------------------------------- |
| id          | INT          | Primary key, auto increment           |
| judul       | VARCHAR(150) | Wajib                                 |
| sutradara   | VARCHAR(100) | Wajib                                 |
| genre       | VARCHAR(50)  | Wajib                                 |
| tahun_rilis | SMALLINT     | Wajib, 1888 sampai tahun sekarang + 5 |
| durasi      | SMALLINT     | Wajib, menit, 1 sampai 999            |
| rating      | DECIMAL(3,1) | Wajib, 0 sampai 10                    |
| created_at  | TIMESTAMP    | Otomatis                              |

## Fitur

- Menampilkan daftar film
- Menambah, mengubah, dan menghapus film
- Validasi input di sisi server
- Prepared statement (PDO) pada semua query yang menerima input
- Escaping output dengan `htmlspecialchars()`
- Pesan sukses dan gagal setiap operasi

## Histori Git

Lihat tahapan pengembangan dengan:
`git log --oneline --graph --decorate`
