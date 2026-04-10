<?php
require_once __DIR__ . '/../config.php';

class m_koneksi {

    private $host = "localhost";
    private $username = "root";
    private $pass = "";
    private $db = "ukk_1_Andi";

    public $koneksi;

    function __construct() {
        $this->koneksi = new mysqli(
            $this->host,
            $this->username,
            $this->pass,
            $this->db
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }
}

// bikin variabel global biar gampang dipakai
$con = new m_koneksi();
$koneksi = $con->koneksi;

?>