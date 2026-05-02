<?php
require_once 'controllers/DonorController.php';

header('Content-Type: application/json');

$controller = new DonorController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($path == 'stok' && $method == 'GET') {
    $controller->listStok();
} 
elseif ($path == 'register' && $method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $controller->register($input);
}

elseif (preg_match('/^update\/(\d+)$/', $path, $matches) && ($method == 'PUT' || $method == 'PATCH')) {
    $id = $matches[1];
    $input = json_decode(file_get_contents('php://input'), true);
    $controller->update($id, $input);
}

elseif (preg_match('/^delete\/(\d+)$/', $path, $matches) && $method == 'DELETE') {
    $id = $matches[1];
    $controller->delete($id);
} 
else {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Endpoint gak ketemu njir, cek path atau method-nya!"
    ]);
}

