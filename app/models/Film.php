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
}