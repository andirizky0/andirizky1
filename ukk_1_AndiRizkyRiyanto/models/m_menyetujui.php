<?php
include_once __DIR__ . '/m_koneksi.php';

class m_menyetujui {
    private $db;

    public function __construct() {
        $this->db = (new m_koneksi())->koneksi;
    }

    // ambil data menunggu
    public function getPengajuan() {
        return mysqli_query($this->db,
            "SELECT * FROM peminjaman WHERE status='menunggu'"
        );
    }

    // ambil 1 peminjaman
    public function getById($id) {
        $q = mysqli_query($this->db,
            "SELECT * FROM peminjaman WHERE id_peminjaman='$id'"
        );
        return mysqli_fetch_assoc($q);
    }

    // ACC peminjaman
    public function setujui($id) {

        // ambil data pinjam
        $data = $this->getById($id);
        $nama_alat = $data['nama_alat'];
        $jumlah    = $data['jumlah'];

        // 🔥 ambil ID alat berdasar nama
        $alat = mysqli_query($this->db,
            "SELECT id_alat, tersedia 
             FROM alat 
             WHERE nama_alat='$nama_alat' 
             LIMIT 1"
        );

        $alat = mysqli_fetch_assoc($alat);

        // ❌ jika alat tidak ditemukan
        if (!$alat) {
            return false;
        }

        // ❌ jika stok kurang
        if ($alat['tersedia'] < $jumlah) {
            return false;
        }

        // 🔥 kurangi stok
        mysqli_query($this->db,
            "UPDATE alat 
             SET tersedia = tersedia - $jumlah 
             WHERE id_alat='{$alat['id_alat']}'"
        );

        // 🔥 update status peminjaman
        mysqli_query($this->db,
            "UPDATE peminjaman 
             SET status='dipinjam' 
             WHERE id_peminjaman='$id'"
        );

        return true;
    }

    // tolak
    public function tolak($id) {
        return mysqli_query($this->db,
            "UPDATE peminjaman 
             SET status='ditolak' 
             WHERE id_peminjaman='$id'"
        );
    }
}