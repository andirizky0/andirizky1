<?php
include_once __DIR__ . '/../models/m_koneksi.php';
include_once __DIR__ . '/../models/m_dashboard.php';

class c_dashboard {

    private $model;

    public function __construct() {
        $db = new m_koneksi();
        $this->model = new m_dashboard($db->koneksi);
    }

    public function countUser() {
        return $this->model->countUser();
    }

    public function countAlat() {
        return $this->model->countAlat();
    }

    public function countKategori() {
        return $this->model->countKategori();
    }
}