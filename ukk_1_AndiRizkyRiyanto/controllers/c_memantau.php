<?php
include_once __DIR__ . '/../models/m_memantau.php';

class c_memantau {
    private $model;

    public function __construct() {
        $this->model = new m_memantau();
    }

    public function index() {
        return $this->model->getAll();
    }
}
?>