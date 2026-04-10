<?php
include_once __DIR__ . '/../models/m_kategori.php';
include_once __DIR__ . '/../models/m_koneksi.php';

class c_kategori {

    private $model;

    public function __construct() {
        $db = new m_koneksi();
        $this->model = new m_kategori($db->koneksi);
    }

    public function index() {
        return $this->model->getAll();
    }

    public function getById($id) {
        return $this->model->getById($id); // sudah array
    }

    public function update($id, $nama) {
        return $this->model->update($id, $nama);
    }

    public function handleAksi() {

        if (isset($_POST['tambah'])) {
            $this->model->tambah($_POST['nama_kategori']);
            header("Location: " . BASE_URL . "views/admin/kategori/tampil_data_kategori.php");
            exit;
        }

        if (isset($_GET['hapus'])) {
            $this->model->hapus($_GET['hapus']);
            header("Location: " . BASE_URL . "views/admin/kategori/tampil_data_kategori.php");
            exit;
        }
    }
}