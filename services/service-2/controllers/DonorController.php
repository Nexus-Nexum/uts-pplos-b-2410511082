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
    if (empty($input['nama']) || empty($input['golongan_darah'])) {
        http_response_code(422);
        echo json_encode([
            "status" => "error",
            "message" => "Nama sama Golongan Darah jangan dikosongin!"
        ]);
        return;
    }

    $id = $this->model->saveStok(
        $input['nama'], 
        $input['golongan_darah'], 
        $input['jumlah_kantong'] ?? 0, 
        $input['lokasi'] ?? ''
    );
    
    echo json_encode([
        "status" => "success",
        "message" => "Data donor berhasil masuk ke database!",
        "data" => ["id" => $id]
    ]);
}

    public function update($id, $input) {
        if (empty($input['nama']) || empty($input['golongan_darah'])) {
            http_response_code(422);
            echo json_encode([
                "status" => "error",
                "message" => "Data update gak boleh kosong!"
            ]);
            return;
        }

        $result = $this->model->updateStok($id, $input['nama'], $input['golongan_darah'], $input['jumlah_kantong'], $input['lokasi']);

        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Data donor ID $id beneran ke-update di database!"
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Gagal update data, ID-nya ada gak?"
            ]);
        }
    }

    public function delete($id) {
        $result = $this->model->deleteStok($id);

        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Data donor ID $id udah ilang dari dunia!"
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Gagal hapus, mungkin ID-nya udah gak ada"
            ]);
        }
    }
}