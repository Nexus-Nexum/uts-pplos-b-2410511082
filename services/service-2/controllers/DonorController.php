<?php
require_once 'models/DonorModel.php';

class DonorController {
    private $model;

    public function __construct() {
        $this->model = new DonorModel('db-system', 'root', 'password', 'donor_db');
    }

    public function listStok() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
        $gol = $_GET['gol'] ?? null;

        $data = $this->model->getStokWithPaging($page, $per_page, $gol);
        
        echo json_encode([
            "status" => "success",
            "meta" => [
                "page" => $page,
                "per_page" => $per_page
            ],
            "data" => $data
        ]);
    }

    public function register($input) {
        if (empty($input['nama']) || empty($input['gol_darah'])) {
            http_response_code(422);
            echo json_encode([
                "status" => "error",
                "message" => "Nama sama Golongan Darah jangan dikosongin lu!"
            ]);
            return;
        }

        $id = $this->model->savePendonor($input['nama'], $input['gol_darah']);
        
        echo json_encode([
            "status" => "success",
            "message" => "Pendonor berhasil didaftar loh!",
            "data" => ["id" => $id]
        ]);
    }
}