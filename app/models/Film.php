<?php
class Film
{
    public function __construct(private PDO $db) {}

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id, judul, sutradara, genre, tahun_rilis, durasi, rating
             FROM film
             ORDER BY judul'
        );
        return $stmt->fetchAll();
    }
    public function insert(array $data): bool
    {
        $sql = 'INSERT INTO film (judul, sutradara, genre, tahun_rilis, durasi, rating)
                VALUES (:judul, :sutradara, :genre, :tahun_rilis, :durasi, :rating)';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':judul'       => $data['judul'],
            ':sutradara'   => $data['sutradara'],
            ':genre'       => $data['genre'],
            ':tahun_rilis' => $data['tahun_rilis'],
            ':durasi'      => $data['durasi'],
            ':rating'      => $data['rating']
        ]);
    }
        public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id, judul, sutradara, genre, tahun_rilis, durasi, rating
             FROM film
             WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE film
                SET judul = :judul,
                    sutradara = :sutradara,
                    genre = :genre,
                    tahun_rilis = :tahun_rilis,
                    durasi = :durasi,
                    rating = :rating
                WHERE id = :id';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'          => $id,
            ':judul'       => $data['judul'],
            ':sutradara'   => $data['sutradara'],
            ':genre'       => $data['genre'],
            ':tahun_rilis' => $data['tahun_rilis'],
            ':durasi'      => $data['durasi'],
            ':rating'      => $data['rating']
        ]);
    }
}