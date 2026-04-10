<?php
class m_log_aktivitas {

    private $conn;
    private $table = "log_aktivitas";

    public function __construct($koneksi_obj) {
        $this->conn = $koneksi_obj->koneksi;
    }

    // ambil semua data log
    public function getAll() {
        $query = "SELECT * FROM {$this->table} 
                  ORDER BY tanggal_aktivitas DESC";
        return mysqli_query($this->conn, $query);
    }

    // tambah log aktivitas
    public function insert($nama, $aktivitas) {

        $nama      = mysqli_real_escape_string($this->conn, $nama);
        $aktivitas = mysqli_real_escape_string($this->conn, $aktivitas);

        $query = "INSERT INTO {$this->table} 
                  (nama, aktivitas, tanggal_aktivitas)
                  VALUES ('$nama', '$aktivitas', NOW())";

        return mysqli_query($this->conn, $query);
    }

    // hapus log (opsional)
    public function delete($id) {
        $id = (int)$id;
        return mysqli_query($this->conn, "
            DELETE FROM {$this->table} WHERE id_log = $id
        ");
    }
}
?>