<?php
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['url'] ?? '';

$stok_darah = [
    ["golongan" => "A+", "stok" => 15],
    ["golongan" => "B+", "stok" => 8],
    ["golongan" => "O", "stok" => 25]
];

if ($path == 'stok' && $method == 'GET') {
    echo json_encode(["status" => "success", "data" => $stok_darah]);
} 
elseif ($path == 'register' && $method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    echo json_encode([
        "status" => "success", 
        "message" => "Pendonor " . ($input['nama'] ?? 'Anonim') . " berhasil didaftar!"
    ]);
} 
else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint di Service-2 gak ketemu"]);
}