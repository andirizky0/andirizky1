<?php
class m_petugas {
    private $koneksi;

    public function __construct($db){
        $this->koneksi = $db;
    }

    // ================= COUNT =================
    public function countMenunggu(){
        $q = $this->koneksi->query("SELECT COUNT(*) as jml FROM peminjaman WHERE status='menunggu'");
        return $q ? $q->fetch_assoc()['jml'] : 0;
    }

    public function countDisetujui(){
        $q = $this->koneksi->query("SELECT COUNT(*) as jml FROM peminjaman WHERE status='dipinjam'");
        return $q ? $q->fetch_assoc()['jml'] : 0;
    }

    public function countPengembalian(){
        $q = $this->koneksi->query("SELECT COUNT(*) as jml FROM pengembalian");
        return $q ? $q->fetch_assoc()['jml'] : 0;
    }

    public function countLog(){
        $q = $this->koneksi->query("SELECT COUNT(*) as jml FROM log_aktivitas");
        return $q ? $q->fetch_assoc()['jml'] : 0;
    }

    // ================= AKTIVITAS =================
    public function getAktivitas(){
        $q = $this->koneksi->query("SELECT * FROM log_aktivitas ORDER BY id_log DESC LIMIT 5");

        if(!$q){
            return []; // penting: kalau error jangan return false
        }

        $data = [];
        while($row = $q->fetch_assoc()){
            $data[] = $row;
        }

        return $data; // return array, bukan object
    }
}