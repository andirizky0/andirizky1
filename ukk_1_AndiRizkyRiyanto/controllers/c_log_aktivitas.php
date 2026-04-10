<?php
include_once __DIR__ . '/../models/m_log_aktivitas.php';

class c_log_aktivitas {

    private $model;

    public function __construct($koneksi_obj) {
        $this->model = new m_log_aktivitas($koneksi_obj);
    }

    // tampilkan semua log
    public function index() {
        return $this->model->getAll();
    }

    // tambah log
    public function tambah($nama, $aktivitas) {
        return $this->model->insert($nama, $aktivitas);
    }

    // hapus log (opsional)
    public function hapus($id) {
        return $this->model->delete($id);
    }
}
?>