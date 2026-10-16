<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/models/Film.php';
require __DIR__ . '/../app/controllers/FilmController.php';

$db         = (new Database())->connect();
$model      = new Film($db);
$controller = new FilmController($model);

$page   = $_GET['page'] ?? 'film';
$action = $_GET['action'] ?? 'index';

if ($page !== 'film') {
    http_response_code(404);
    exit('Halaman tidak ditemukan.');
}

match ($action) {
    'index'  => $controller->index(),
    'create' => $controller->create(),
    'store'  => $controller->store(),
    'edit'   => $controller->edit(),
    'update' => $controller->update(),
    'delete' => $controller->delete(),
    default  => (function () {
        http_response_code(404);
        exit('Action tidak ditemukan.');
    })()
};