<?php
include_once __DIR__ . '/../models/m_laporan.php';

class c_laporan {

    private $model;

    public function __construct() {
        $this->model = new m_laporan();
    }

    public function index() {

        date_default_timezone_set('Asia/Jakarta');

        return [
            'data' => $this->model->getAll(),
            'tanggal' => date("d-m-Y") // otomatis hari ini
        ];
    }
}
?>