<?php

class m_dashboard {

    private $conn;

    public function __construct($conn) {
        // terima koneksi dari controller
        $this->conn = $conn;
    }

    public function countUser() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM users");
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function countAlat() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM alat");
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function countKategori() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM kategori");
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}