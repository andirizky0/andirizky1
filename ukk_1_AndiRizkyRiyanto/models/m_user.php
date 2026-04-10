<?php
include_once __DIR__ . "/m_koneksi.php";

class m_user {

    private $koneksi;

    public function __construct(){
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    // tampil semua user
    public function getAll(){
        $sql = "SELECT * FROM users ORDER BY id_user DESC";
        return mysqli_query($this->koneksi, $sql);
    }

    // ambil 1 user
    public function getById($id){
        $sql = "SELECT * FROM users WHERE id_user='$id'";
        return mysqli_query($this->koneksi, $sql);
    }

    // tambah user
    public function insert($nama,$email,$no_tlp,$password,$role){
        $sql = "INSERT INTO users 
                (nama,email,no_tlp,password,role)
                VALUES 
                ('$nama','$email','$no_tlp','$password','$role')";
        return mysqli_query($this->koneksi,$sql);
    }

    // 🔥 TAMBAHAN: UPDATE USER
    public function update($id, $nama, $email, $no_tlp, $password){
        $sql = "UPDATE users SET 
                nama='$nama',
                email='$email',
                no_tlp='$no_tlp',
                password='$password'
                WHERE id_user='$id'";
        return mysqli_query($this->koneksi, $sql);
    }

    // update role user
    public function updateRole($id,$role){
        $sql = "UPDATE users SET role='$role' WHERE id_user='$id'";
        return mysqli_query($this->koneksi,$sql);
    }

    // hapus user
    public function delete($id){
        $sql = "DELETE FROM users WHERE id_user='$id'";
        return mysqli_query($this->koneksi,$sql);
    }
}