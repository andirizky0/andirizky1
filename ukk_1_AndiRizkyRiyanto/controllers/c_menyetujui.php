<?php
include_once __DIR__ . '/../models/m_menyetujui.php';

class c_menyetujui {
    private $model;

    public function __construct() {
        $this->model = new m_menyetujui();
    }

    public function index() {
        return $this->model->getPengajuan();
    }

    public function proses() {
        if (isset($_GET['acc'])) {
            $this->model->setujui($_GET['acc']);
            header("Location: " . BASE_URL . "views/petugas/menyetujui.php");
            exit;
        }

        if (isset($_GET['tolak'])) {
            $this->model->tolak($_GET['tolak']);
            header("Location: " . BASE_URL . "views/petugas/menyetujui.php");
            exit;
        }
    }
}