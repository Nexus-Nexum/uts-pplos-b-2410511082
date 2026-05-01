<?php
class DonorModel {
    private $db;

    public function __construct($host, $user, $pass, $dbname) {
        $this->db = new mysqli($host, $user, $pass, $dbname);

        if ($this->db->connect_error) {
            die("Koneksi gagal: " . $this->db->connect_error);
        }
    }

    public function getStokWithPaging($page, $per_page, $filter_gol = null) {
        $offset = ($page - 1) * $per_page;
        
        $query = "SELECT * FROM stok_darah";
        
        if ($filter_gol) {
            $query .= " WHERE golongan_darah = '" . $this->db->real_escape_string($filter_gol) . "'";
        }
        
        $query .= " LIMIT $per_page OFFSET $offset";
        
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function savePendonor($nama, $gol) {
        $stmt = $this->db->prepare("INSERT INTO pendonors (nama, golongan_darah) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama, $gol);
        $stmt->execute();
        return $stmt->insert_id;
    }
}