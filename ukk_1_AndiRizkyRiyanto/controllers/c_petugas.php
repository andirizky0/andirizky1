<?php
include_once __DIR__ . '/../models/m_koneksi.php';
include_once __DIR__ . '/../models/m_petugas.php';

class c_petugas {

    private $model;

    public function __construct(){
        global $koneksi;
        $this->model = new m_petugas($koneksi);
    }

    public function dashboard(){
        return [
            'menunggu' => $this->model->countMenunggu(),
            'disetujui' => $this->model->countDisetujui(),
            'pengembalian' => $this->model->countPengembalian(),
            'log' => $this->model->countLog(),
            'aktivitas' => $this->model->getAktivitas()
        ];
    }
}