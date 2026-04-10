<?php
include_once __DIR__ . "/../models/m_user.php";

class c_user {

    public $model;

    public function __construct(){
        $this->model = new m_user();
    }

    public function index(){
        return $this->model->getAll();
    }

    // AMBIL DATA BY ID
    public function getById($id){
        $result = $this->model->getById($id);
        return mysqli_fetch_assoc($result);
    }

    // EDIT USER
    public function edit($id, $data){
        $nama     = $data['nama'];
        $email    = $data['email'];
        $no_tlp   = $data['no_tlp'];
        $password = $data['password'];

        $this->model->update($id, $nama, $email, $no_tlp, $password);
    }

    public function store(){
        $nama     = $_POST['nama'] ?? '';
        $email    = $_POST['email'] ?? '';
        $no_tlp   = $_POST['no_tlp'] ?? '';
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? '';

        $this->model->insert($nama, $email, $no_tlp, $password, $role);

        header("Location: " . BASE_URL . "views/admin/user/tampil_data.php");
        exit;
    }

    public function updateRole(){
        $id   = $_POST['id_user'] ?? null;
        $role = $_POST['role'] ?? null;

        if($id && $role){
            $this->model->updateRole($id, $role);
        }

        header("Location: " . BASE_URL . "views/admin/user/tampil_data.php");
        exit;
    }

    public function destroy($id){
        $this->model->delete($id);

        header("Location: " . BASE_URL . "views/admin/user/tampil_data.php");
        exit;
    }

    public function handleAksi(){
        if(isset($_GET['aksi'])){
            if($_GET['aksi'] == "hapus"){
                $id = $_GET['id'] ?? null;
                if($id){
                    $this->destroy($id);
                }
            }

            if($_GET['aksi'] == "edit_role"){
                $this->updateRole();
            }
        }
    }
}

if(isset($_GET['aksi'])){
    $controller = new c_user();
    $controller->handleAksi();
}