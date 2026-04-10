<?php
// Sesuaikan path dengan benar
include_once __DIR__ . '/../models/m_peminjaman.php';

class c_peminjaman {
    private $model;

    public function __construct() {
        $this->model = new m_peminjaman();
    }

    public function index() {
        return $this->model->getAll();
    }

    public function tambah($data) {
        return $this->model->insert($data);
    }

    public function edit($id, $data) {
        return $this->model->update($id, $data);
    }

    public function hapus($id) {
        return $this->model->delete($id);
    }

    public function getById($id) {
        return $this->model->getById($id);
    }
}
?>