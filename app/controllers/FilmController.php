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

        public function edit(): void
    {
        $id   = (int) ($_GET['id'] ?? 0);
        $film = $this->model->findById($id);

        if (!$film) {
            http_response_code(404);
            exit('Data film tidak ditemukan.');
        }

        $errors = [];
        require __DIR__ . '/../views/film/edit.php';
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=film');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (!$this->model->findById($id)) {
            http_response_code(404);
            exit('Data film tidak ditemukan.');
        }

        [$data, $errors] = $this->validateInput($_POST);

        if (!empty($errors)) {
            // Tampilkan form lagi dengan isian yang sudah diketik pengguna
            $film = ['id' => $id] + $data;
            require __DIR__ . '/../views/film/edit.php';
            return;
        }

        $this->model->update($id, $data);
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