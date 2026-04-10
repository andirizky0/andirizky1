<?php
class m_kategori {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        return mysqli_query($this->conn, "SELECT * FROM kategori");
    }

    // 🔥 FIX DI SINI
    public function getById($id) {
        $result = mysqli_query(
            $this->conn,
            "SELECT * FROM kategori WHERE id_kategori='$id'"
        );
        return mysqli_fetch_assoc($result); // ✅ jadi array
    }

    public function tambah($nama) {
        return mysqli_query(
            $this->conn,
            "INSERT INTO kategori (nama_kategori) VALUES ('$nama')"
        );
    }

    public function update($id, $nama) {
        return mysqli_query(
            $this->conn,
            "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori='$id'"
        );
    }

    public function hapus($id) {
        return mysqli_query(
            $this->conn,
            "DELETE FROM kategori WHERE id_kategori='$id'"
        );
    }
}