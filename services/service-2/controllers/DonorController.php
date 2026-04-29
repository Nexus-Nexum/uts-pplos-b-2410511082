<?php
require_once 'models/DonorModel.php';

class DonorController {
    private $model;

    public function __construct() {
        $this->model = new DonorModel('db-system', 'root', 'password', 'donor_db');
    }

    public function index() {
        $data = $this->model->getStokDarah();
        echo json_encode(["status" => "success", "data" => $data]);
    }

    public function register($input) {
        echo json_encode(["message" => "Berhasil daftar loh!"]);
    }
}