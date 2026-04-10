<?php
include_once __DIR__ . '/m_koneksi.php';

class m_memantau {
    private $koneksi;

    public function __construct() {
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    // 🔥 AUTO UPDATE (AMAN - TIDAK GANGGU MENUNGGU)
    public function autoUpdate() {

        // ✅ DIKEMBALIKAN (hanya dari dipinjam/terlambat)
        $this->koneksi->query("
            UPDATE peminjaman p
            LEFT JOIN pengembalian k 
            ON p.id_peminjaman = k.id_peminjaman
            SET 
                p.status = 'dikembalikan',
                p.tanggal_kembali = k.tanggal_dikembalikan
            WHERE 
                k.id_peminjaman IS NOT NULL
                AND p.status IN ('dipinjam','terlambat')
        ");

        // ✅ TERLAMBAT (hanya dari dipinjam)
        $this->koneksi->query("
            UPDATE peminjaman 
            SET status = 'terlambat'
            WHERE 
                status = 'dipinjam'
                AND CURDATE() > tanggal_kembali
        ");
    }

    // 🔥 AMBIL DATA (tanpa menunggu)
    public function getAll() {
        $this->autoUpdate();

        return $this->koneksi->query("
            SELECT 
                p.*,
                k.tanggal_dikembalikan AS tgl_kembali_real
            FROM peminjaman p
            LEFT JOIN pengembalian k 
            ON p.id_peminjaman = k.id_peminjaman
            WHERE p.status != 'menunggu'
            ORDER BY p.id_peminjaman DESC
        ");
    }
}
?>