<?php
include __DIR__ . '/../models/m_alat.php';

class c_alat {

    private $model;

    public function __construct()
    {
        $this->model = new m_alat();
    }

    public function index()
    {
        $data['total_alat'] = $this->model->total_alat();
        $data['alat'] = $this->model->get_all();
        return $data;
    }

    // 🔥 AMBIL DATA BERDASARKAN ID
    public function getById($id)
    {
        return $this->model->get_by_id($id);
    }

    // 🔥 HANDLE AKSI CRUD
    public function handleAksi()
    {
        // TAMBAH
        if(isset($_POST['tambah'])){
            $this->model->insert($_POST['nama'], $_POST['stok'], $_POST['tersedia'], $_POST['kondisi']);
            header("Location: tampil_data_alat.php");
            exit;
        }

        // EDIT
        if(isset($_POST['edit'])){
            $this->model->update($_POST['id'], $_POST['nama'], $_POST['stok'], $_POST['tersedia'], $_POST['kondisi']);
            header("Location: tampil_data_alat.php");
            exit;
        }

        // HAPUS
        if(isset($_GET['hapus'])){
            $this->model->delete($_GET['hapus']);
            header("Location: tampil_data_alat.php");
            exit;
        }
    }
}
?>