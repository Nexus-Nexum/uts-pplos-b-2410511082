<?php
require_once 'controllers/DonorController.php';

header('Content-Type: application/json');

$controller = new DonorController();

$path = trim($_SERVER['REQUEST_URI'], '/');

$method = $_SERVER['REQUEST_METHOD'];

if ($path == 'stok' && $method == 'GET') {
    $controller->listStok();
} 
elseif ($path == 'register' && $method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $controller->register($input);
} 
else {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Endpoint gak ketemu, cek lagi path atau method-nya!"
    ]);
}