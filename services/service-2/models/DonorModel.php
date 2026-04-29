<?php
class DonorModel {
    private $db;

    public function __construct($host, $user, $pass, $dbname) {
        $this->db = new mysqli($host, $user, $pass, $dbname);
    }

    public function getStokDarah() {
        $result = $this->db->query("SELECT * FROM stok_darah");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function simpanPendonor($data) {
        // Logic simpan ke tabel pendonor
        return true; 
    }
}