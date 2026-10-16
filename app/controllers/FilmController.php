<?php
class FilmController
{
    public function __construct(private Film $model) {}

    public function index(): void
    {
        $films = $this->model->getAll();
        require __DIR__ . '/../views/film/index.php';
    }

    public function create(): void
    {
        $errors = [];
        $old    = [];
        require __DIR__ . '/../views/film/create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=film');
            exit;
        }

        [$data, $errors] = $this->validateInput($_POST);

        if (!empty($errors)) {
            $old = $data;
            require __DIR__ . '/../views/film/create.php';
            return;
        }

        $this->model->insert($data);
        header('Location: index.php?page=film');
        exit;
    }

    private function validateInput(array $input): array
    {
        $data = [
            'judul'       => trim($input['judul'] ?? ''),
            'sutradara'   => trim($input['sutradara'] ?? ''),
            'genre'       => trim($input['genre'] ?? ''),
            'tahun_rilis' => trim($input['tahun_rilis'] ?? ''),
            'durasi'      => trim($input['durasi'] ?? ''),
            'rating'      => trim($input['rating'] ?? '')
        ];

        $labels = [
            'judul'       => 'Judul',
            'sutradara'   => 'Sutradara',
            'genre'       => 'Genre',
            'tahun_rilis' => 'Tahun rilis',
            'durasi'      => 'Durasi',
            'rating'      => 'Rating'
        ];

        $errors = [];

        // 1. Field wajib
        foreach ($labels as $field => $label) {
            if ($data[$field] === '') {
                $errors[] = "$label wajib diisi.";
            }
        }

        // 2. Aturan khusus (hanya dicek jika field tidak kosong)
        if ($data['judul'] !== '' && mb_strlen($data['judul']) > 150) {
            $errors[] = 'Judul maksimal 150 karakter.';
        }

        if ($data['tahun_rilis'] !== '') {
            $maxYear = (int) date('Y') + 5;
            $ok = filter_var($data['tahun_rilis'], FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 1888, 'max_range' => $maxYear]
            ]);
            if ($ok === false) {
                $errors[] = "Tahun rilis harus angka antara 1888 dan $maxYear.";
            }
        }

        if ($data['durasi'] !== '') {
            $ok = filter_var($data['durasi'], FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 1, 'max_range' => 999]
            ]);
            if ($ok === false) {
                $errors[] = 'Durasi harus angka bulat antara 1 dan 999 menit.';
            }
        }

        if ($data['rating'] !== '') {
            if (!is_numeric($data['rating']) || $data['rating'] < 0 || $data['rating'] > 10) {
                $errors[] = 'Rating harus angka antara 0 dan 10.';
            }
        }

        return [$data, $errors];
    }
}