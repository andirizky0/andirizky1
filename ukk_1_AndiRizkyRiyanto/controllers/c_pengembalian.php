<?php
include_once __DIR__ . '/../models/m_pengembalian.php';

class c_pengembalian {
    private $model;

    public function __construct() {
        $this->model = new m_pengembalian();
    }

    // tampil semua data pengembalian (untuk admin)
    public function index() {
        return $this->model->getAll();
    }

    // handle semua aksi (hapus & kembalikan)
    public function handleAksi() {

        // =========================
        // AKSI KEMBALIKAN (USER)
        // =========================
        if (isset($_GET['kembalikan'])) {

            $id = $_GET['kembalikan'];
            $kondisi = $_GET['kondisi'] ?? 'Baik';

            // validasi sederhana
            if ($id == '' || !is_numeric($id)) {
                echo "<script>alert('ID tidak valid');</script>";
                return;
            }

            // insert ke tabel pengembalian + update status + restore stok
            $this->model->insert($id, $kondisi);

            // redirect ke halaman admin pengembalian
            header("Location: " . BASE_URL . "views/admin/pengembalian/tampil_data_pengembalian.php");
            exit;
        }


        // =========================
        // AKSI HAPUS (ADMIN)
        // =========================
        if (isset($_GET['hapus'])) {

            $id = $_GET['hapus'];

            if ($id == '' || !is_numeric($id)) {
                echo "<script>alert('ID tidak valid');</script>";
                return;
            }

            $this->model->delete($id);

            header("Location: " . BASE_URL . "views/admin/pengembalian/tampil_data_pengembalian.php");
            exit;
        }
    }
}
?>