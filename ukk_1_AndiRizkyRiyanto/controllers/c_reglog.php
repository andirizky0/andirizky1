<?php
session_start();
include_once __DIR__ . '/../models/m_reglog.php';

$login = new m_reglog();

if (!isset($_GET['aksi'])) {
    header("Location: " . BASE_URL . "views/index.php");
    exit;
}

$aksi = $_GET['aksi'];


// ================= REGISTRASI =================
if ($aksi === 'register') {

    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $no_tlp   = $_POST['no_tlp'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ubah ke huruf kecil
    $role     = strtolower($_POST['role']);

    $result = $login->register($nama, $email, $no_tlp, $password, $role);

    if ($result) {
        echo "<script>
                alert('Registrasi berhasil, silakan login');
                window.location='" . BASE_URL . "views/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal');
                window.location='" . BASE_URL . "views/register.php';
              </script>";
    }
    exit;
}


// ================= LOGIN =================
elseif ($aksi === 'login') {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $data = $login->login($email, $password);

    if ($data) {

        // NORMALISASI ROLE
        $role = strtolower($data['role']);

        // SESSION
        $_SESSION['id']      = $data['id_user'];
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama']    = $data['nama'];
        $_SESSION['role']    = $role;

        // REDIRECT DINAMIS
        if ($role === 'admin') {
            header("Location: " . BASE_URL . "views/admin/dashboard_admin.php");
        } elseif ($role === 'petugas') {
            header("Location: " . BASE_URL . "views/petugas/dashboard_petugas.php");
        } elseif ($role === 'peminjam') {
            header("Location: " . BASE_URL . "views/peminjam/dashboard_peminjam.php");
        } else {
            header("Location: " . BASE_URL . "views/index.php");
        }
        exit;

    } else {
        echo "<script>
                alert('Email atau password salah');
                window.location='" . BASE_URL . "views/index.php';
              </script>";
    }
    exit;
}
?>