<?php
include_once __DIR__ . '/m_koneksi.php';

class m_mengajukan {
    public $db;

    public function __construct() {
        $this->db = (new m_koneksi())->koneksi;
    }

    public function getAlat() {
        $query = "
            SELECT a.nama_alat, MAX(a.stok) AS stok, MAX(a.tersedia) AS tersedia, MAX(a.kondisi) AS kondisi, MAX(k.nama_kategori) AS nama_kategori
            FROM alat a
            LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
            GROUP BY a.nama_alat
            ORDER BY a.nama_alat ASC
        ";
        $result = mysqli_query($this->db, $query);
        if (!$result) die("Query Error (getAlat): " . mysqli_error($this->db));
        return $result;
    }

    public function simpan($data) {
        $nama    = mysqli_real_escape_string($this->db, $data['nama_peminjam']);
        $alat    = mysqli_real_escape_string($this->db, $data['nama_alat']);
        $jumlah  = (int)$data['jumlah'];
        $ukuran  = mysqli_real_escape_string($this->db, $data['ukuran']);
        $pinjam  = mysqli_real_escape_string($this->db, $data['tanggal_pinjam']);
        $kembali = mysqli_real_escape_string($this->db, $data['tanggal_kembali']);
        $status  = mysqli_real_escape_string($this->db, $data['status']);

        if (strtotime($pinjam) > strtotime($kembali)) die("Tanggal kembali harus setelah tanggal pinjam!");

        $query = "
            INSERT INTO peminjaman
            (nama_peminjam, nama_alat, jumlah, ukuran, tanggal_pinjam, tanggal_kembali, status)
            VALUES
            ('$nama', '$alat', $jumlah, '$ukuran', '$pinjam', '$kembali', '$status')
        ";
        $result = mysqli_query($this->db, $query);
        if (!$result) die("Query Error (simpan): " . mysqli_error($this->db));

        return mysqli_insert_id($this->db);
    }

    public function getByUser($nama_peminjam) {
        $nama_peminjam = mysqli_real_escape_string($this->db, $nama_peminjam);
        $query = "SELECT * FROM peminjaman WHERE nama_peminjam='$nama_peminjam' ORDER BY id_peminjaman DESC";
        $result = mysqli_query($this->db, $query);
        if (!$result) die("Query Error (getByUser): " . mysqli_error($this->db));
        return $result;
    }
}