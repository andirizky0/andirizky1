<?php
include_once __DIR__ . '/m_koneksi.php';

class m_peminjaman {
    private $conn;

    public function __construct() {
        $db = new m_koneksi();
        $this->conn = $db->koneksi;
    }

    // Ambil semua data peminjaman
    public function getAll() {
        $this->autoUpdateStatus(); // update status otomatis sebelum tampil
        $sql = "SELECT * FROM peminjaman ORDER BY id_peminjaman DESC";
        return $this->conn->query($sql);
    }

    // Ambil data by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM peminjaman WHERE id_peminjaman=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Tambah peminjaman
    public function insert($data) {
        $nama_peminjam  = $this->conn->real_escape_string($data['nama_peminjam'] ?? '');
        $nama_alat      = $this->conn->real_escape_string($data['nama_alat'] ?? '');
        $tanggal_pinjam = $this->conn->real_escape_string($data['tanggal_pinjam'] ?? '');
        $tanggal_kembali= $this->conn->real_escape_string($data['tanggal_kembali'] ?? '');
        $jumlah         = (int)($data['jumlah'] ?? 0);
        $keterangan     = $this->conn->real_escape_string($data['keterangan'] ?? '');

        $sql = "INSERT INTO peminjaman 
            (nama_peminjam, nama_alat, tanggal_pinjam, tanggal_kembali, jumlah, keterangan, status) 
            VALUES ('$nama_peminjam', '$nama_alat', '$tanggal_pinjam', '$tanggal_kembali', $jumlah, '$keterangan', 'dipinjam')";
        
        return $this->conn->query($sql);
    }

    // Edit peminjaman
    public function update($id, $data) {
        $nama_peminjam  = $this->conn->real_escape_string($data['nama_peminjam'] ?? '');
        $nama_alat      = $this->conn->real_escape_string($data['nama_alat'] ?? '');
        $tanggal_pinjam = $this->conn->real_escape_string($data['tanggal_pinjam'] ?? '');
        $tanggal_kembali= $this->conn->real_escape_string($data['tanggal_kembali'] ?? '');
        $jumlah         = (int)($data['jumlah'] ?? 0);
        $keterangan     = $this->conn->real_escape_string($data['keterangan'] ?? '');
        $id             = (int)$id;

        $sql = "UPDATE peminjaman SET 
            nama_peminjam='$nama_peminjam', nama_alat='$nama_alat', 
            tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali', 
            jumlah=$jumlah, keterangan='$keterangan' 
            WHERE id_peminjaman=$id";
        
        return $this->conn->query($sql);
    }

    // Hapus peminjaman
    public function delete($id) {
        return $this->conn->query("DELETE FROM peminjaman WHERE id_peminjaman='$id'");
    }

    // Update status otomatis
    public function autoUpdateStatus() {
        // Jika ada pengembalian, set status dikembalikan
        $this->conn->query("
            UPDATE peminjaman p
            JOIN pengembalian k ON p.id_peminjaman=k.id_peminjaman
            SET p.status='dikembalikan'
            WHERE p.status IN ('dipinjam','terlambat')
        ");

        // Jika melewati tanggal kembali tapi belum dikembalikan -> terlambat
        $this->conn->query("
            UPDATE peminjaman 
            SET status='terlambat' 
            WHERE status='dipinjam' AND CURDATE() > tanggal_kembali
        ");
    }
}
?>