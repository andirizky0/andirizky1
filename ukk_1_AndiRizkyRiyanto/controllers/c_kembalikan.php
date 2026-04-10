<?php
include_once __DIR__ . '/../models/m_kembalikan.php';

/* TAMBAHAN LOG */
include_once __DIR__ . '/../models/m_koneksi.php';
include_once __DIR__ . '/c_log_aktivitas.php';

class c_kembalikan {
    private $model;

    /* TAMBAHAN */
    private $log;

    public function __construct() {
        $this->model = new m_kembalikan();

        /* TAMBAHAN */
        $koneksi = new m_koneksi();
        $this->log = new c_log_aktivitas($koneksi);
    }

    // tampil data peminjaman berdasarkan user login
    public function index($nama_user) {
        return $this->model->getByUser($nama_user);
    }

    // proses tombol kembalikan
    public function proses() {

        if (isset($_GET['kembalikan'])) {
            $id = (int) $_GET['kembalikan'];
            $kondisi = $_GET['kondisi'] ?? 'Baik';

            // Validasi kondisi
            $valid_kondisi = ['Baik', 'Rusak', 'Hilang'];
            if (!in_array($kondisi, $valid_kondisi)) {
                $kondisi = 'Baik';
            }

            // ambil data peminjaman
            $data = $this->model->getById($id);

            if (!$data) {
                die("Data tidak ditemukan");
            }

            // insert data ke tabel pengembalian dengan denda otomatis
            $this->model->insertPengembalian($data, $kondisi);

            // update status peminjaman menjadi 'dikembalikan'
            $this->model->updateStatus($id);

            // Kembalikan stok alat
            $this->model->restoreStok($data['nama_alat'], $data['jumlah']);

            /* LOG AKTIVITAS */
            $nama = $data['nama_peminjam'];
            $alat = $data['nama_alat'];

            $this->log->tambah($nama, "Mengembalikan alat: $alat (kondisi: $kondisi)");

            // redirect ke halaman peminjam dengan notifikasi sukses
            header("Location: " . BASE_URL . "views/peminjam/kembalikan.php?success=1");
            exit;
        }
    }
}
?>