<?php
include_once __DIR__ . '/m_koneksi.php';

class m_laporan {
    private $koneksi;

    public function __construct() {
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    public function getAll() {
        $sql = "SELECT * FROM peminjaman ORDER BY id_peminjaman DESC";
        $result = $this->koneksi->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>