<?php
class DonorModel {
    private $db;

    public function __construct($host, $user, $pass, $dbname) {
        $this->db = new mysqli($host, $user, $pass, $dbname);

        if ($this->db->connect_error) {
            die("Koneksi gagal: " . $this->db->connect_error);
        }
    }

    public function getStokWithPaging($page, $per_page, $gol = null) {
        $offset = ($page - 1) * $per_page;
    
        $query = "SELECT * FROM stok_darah";
    
        if ($gol) {
            $query .= " WHERE golongan_darah = '$gol'";
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

    public function updateStok($id, $nama, $gol, $jumlah, $lokasi) {
        $stmt = $this->db->prepare("UPDATE stok_darah SET nama = ?, golongan_darah = ?, jumlah_kantong = ?, lokasi = ? WHERE id = ?");
        return $stmt->execute([$nama, $gol, $jumlah, $lokasi, $id]);
    }

    public function deleteStok($id) {
        $stmt = $this->db->prepare("DELETE FROM stok_darah WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function saveStok($nama, $gol, $jumlah, $lokasi) {
        $stmt = $this->db->prepare("INSERT INTO stok_darah (nama, golongan_darah, jumlah_kantong, lokasi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nama, $gol, $jumlah, $lokasi);
        $stmt->execute();
    
        return $this->db->insert_id; 
    }
}