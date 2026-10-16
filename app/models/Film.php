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
}