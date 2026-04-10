<?php
include_once __DIR__ . '/m_koneksi.php';

class m_pengembalian {
    private $conn;

    public function __construct() {
        $db = new m_koneksi();
        $this->conn = $db->koneksi;
    }

    // Ambil semua pengembalian (JOIN dengan peminjaman untuk info lengkap)
    public function getAll() {
        return $this->conn->query("
            SELECT pg.*, p.nama_peminjam, p.nama_alat, p.tanggal_kembali AS jatuh_tempo
            FROM pengembalian pg
            JOIN peminjaman p ON pg.id_peminjaman = p.id_peminjaman
            ORDER BY pg.id_pengembalian DESC
        ");
    }

    // Hapus pengembalian
    public function delete($id) {
        return $this->conn->query("DELETE FROM pengembalian WHERE id_pengembalian='$id'");
    }

    // Hitung denda otomatis
    public function hitungDenda($tanggal_jatuh_tempo, $tanggal_dikembalikan, $kondisi = 'Baik') {
        $denda = 0;

        // Hitung keterlambatan
        $jatuhTempo = new DateTime($tanggal_jatuh_tempo);
        $dikembalikan = new DateTime($tanggal_dikembalikan);
        
        if ($dikembalikan > $jatuhTempo) {
            $selisih = $jatuhTempo->diff($dikembalikan);
            $hari_terlambat = $selisih->days;
            $denda += $hari_terlambat * DENDA_PER_HARI;
        }

        // Denda kondisi barang
        if (strtolower($kondisi) === 'rusak') {
            $denda += DENDA_RUSAK;
        } elseif (strtolower($kondisi) === 'hilang') {
            $denda += DENDA_HILANG;
        }

        return $denda;
    }

    // Tambah pengembalian dengan denda otomatis
    public function insert($id_peminjaman, $kondisi = 'Baik') {
        // Ambil data peminjaman
        $q = $this->conn->query("SELECT * FROM peminjaman WHERE id_peminjaman='$id_peminjaman'");
        $peminjaman = $q->fetch_assoc();

        if (!$peminjaman) return false;

        $tanggal_dikembalikan = date('Y-m-d');
        $tanggal_jatuh_tempo = $peminjaman['tanggal_kembali'];

        // Hitung denda
        $denda = $this->hitungDenda($tanggal_jatuh_tempo, $tanggal_dikembalikan, $kondisi);

        // Insert ke tabel pengembalian
        $this->conn->query("INSERT INTO pengembalian 
            (id_peminjaman, tanggal_dikembalikan, kondisi_kembali, denda) 
            VALUES ('$id_peminjaman', '$tanggal_dikembalikan', '$kondisi', '$denda')");

        // Update status peminjaman
        $this->conn->query("UPDATE peminjaman SET status='dikembalikan' WHERE id_peminjaman='$id_peminjaman'");

        // Kembalikan stok alat
        $nama_alat = $peminjaman['nama_alat'];
        $jumlah = $peminjaman['jumlah'];
        $this->conn->query("UPDATE alat SET tersedia = tersedia + $jumlah WHERE nama_alat='$nama_alat'");

        return true;
    }
}
?>