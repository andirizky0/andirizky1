<?php
require_once __DIR__ . '/m_koneksi.php';

class m_alat {

    private $db;

    public function __construct()
    {
        $koneksi = new m_koneksi();
        $this->db = $koneksi->koneksi;
    }

    public function get_all()
    {
        return mysqli_query($this->db, "SELECT * FROM alat");
    }

    public function total_alat()
    {
        $query = mysqli_query($this->db, "SELECT COUNT(*) AS total FROM alat");
        $data = mysqli_fetch_assoc($query);
        return $data['total'];
    }

    // ================= CRUD =================

    public function insert($nama, $stok, $tersedia, $kondisi)
    {
        return mysqli_query($this->db, "INSERT INTO alat 
            (nama_alat, stok, tersedia, kondisi, created_at)
            VALUES ('$nama','$stok','$tersedia','$kondisi',NOW())");
    }

    public function get_by_id($id)
    {
        return mysqli_query($this->db, "SELECT * FROM alat WHERE id_alat='$id'");
    }

    public function update($id, $nama, $stok, $tersedia, $kondisi)
    {
        return mysqli_query($this->db, "UPDATE alat SET 
            nama_alat='$nama',
            stok='$stok',
            tersedia='$tersedia',
            kondisi='$kondisi'
            WHERE id_alat='$id'");
    }

    public function delete($id)
    {
        return mysqli_query($this->db, "DELETE FROM alat WHERE id_alat='$id'");
    }

} // ✅ class ditutup DI SINI
?>