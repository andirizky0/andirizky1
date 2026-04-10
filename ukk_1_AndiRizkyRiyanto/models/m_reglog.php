<?php
include_once __DIR__ . '/m_koneksi.php';

class m_reglog
{
    function register($nama, $email, $no_tlp, $password, $role)
    {
      //membuat objek dari kelas m_koneksi
        $conn = new m_koneksi();

        $sql = "INSERT INTO users 
                (nama, email, no_tlp, password, role)
                VALUES 
                ('$nama', '$email', '$no_tlp', '$password', '$role')";

        $query = mysqli_query($conn->koneksi, $sql);

        if (!$query) {
            die(mysqli_error($conn->koneksi));
        }

        return $query;
    }

    function login($email, $password) {
        $conn = new m_koneksi();

        $sql   = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($conn->koneksi, $sql);
        $data  = mysqli_fetch_assoc($query);

        if ($data && password_verify($password, $data['password'])) {
            return $data;
        } else {
            return false;
        }
    }
}
?>