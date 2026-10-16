<?php
class FilmController
{
    public function __construct(private Film $model) {}

    public function index(): void
    {
        $films = $this->model->getAll();

        // Ambil flash message lalu hapus agar hanya tampil sekali
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

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
        $this->requirePost();

        [$data, $errors] = $this->validateInput($_POST);

        if (!empty($errors)) {
            $old = $data;
            require __DIR__ . '/../views/film/create.php';
            return;
        }

        try {
            $this->model->insert($data);
            $this->setFlash('success', 'Film "' . $data['judul'] . '" berhasil ditambahkan.');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->setFlash('error', 'Gagal menyimpan data film. Silakan coba lagi.');
        }

        $this->redirectToList();
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
        $this->requirePost();

        $id = (int) ($_POST['id'] ?? 0);

        if (!$this->model->findById($id)) {
            $this->setFlash('error', 'Data film tidak ditemukan.');
            $this->redirectToList();
        }

        [$data, $errors] = $this->validateInput($_POST);

        if (!empty($errors)) {
            $film = ['id' => $id] + $data;
            require __DIR__ . '/../views/film/edit.php';
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->setFlash('success', 'Film "' . $data['judul'] . '" berhasil diperbarui.');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->setFlash('error', 'Gagal memperbarui data film. Silakan coba lagi.');
        }

        $this->redirectToList();
    }

    public function delete(): void
    {
        $this->requirePost();

        $id   = (int) ($_POST['id'] ?? 0);
        $film = $this->model->findById($id);

        if (!$film) {
            $this->setFlash('error', 'Data film tidak ditemukan atau sudah dihapus.');
            $this->redirectToList();
        }

        try {
            $this->model->delete($id);
            $this->setFlash('success', 'Film "' . $film['judul'] . '" berhasil dihapus.');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->setFlash('error', 'Gagal menghapus data film. Silakan coba lagi.');
        }

        $this->redirectToList();
    }

    // ---------- Helper ----------

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToList();
        }
    }

    private function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    private function redirectToList(): never
    {
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

        foreach ($labels as $field => $label) {
            if ($data[$field] === '') {
                $errors[] = "$label wajib diisi.";
            }
        }

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