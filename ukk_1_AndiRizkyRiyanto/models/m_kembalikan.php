<?php
include_once __DIR__ . '/m_koneksi.php';

class m_kembalikan {
    private $db;

    public function __construct() {
        $this->db = (new m_koneksi())->koneksi;
    }

    // ambil data berdasarkan user login (hanya yang belum dikembalikan)
    public function getByUser($nama) {
        $nama = mysqli_real_escape_string($this->db, $nama);

        $query = "
            SELECT p.*, 
                   CASE 
                       WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali 
                       THEN DATEDIFF(CURDATE(), p.tanggal_kembali) * " . DENDA_PER_HARI . "
                       ELSE 0 
                   END AS estimasi_denda,
                   CASE 
                       WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali 
                       THEN DATEDIFF(CURDATE(), p.tanggal_kembali)
                       ELSE 0 
                   END AS hari_terlambat
            FROM peminjaman p
            WHERE LOWER(nama_peminjam) = LOWER('$nama')
            AND status NOT IN ('dikembalikan', 'ditolak')
            ORDER BY id_peminjaman DESC
        ";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error (getByUser): " . mysqli_error($this->db));
        }

        return $result;
    }

    // ambil data berdasarkan id peminjaman
    public function getById($id) {
        $id = mysqli_real_escape_string($this->db, $id);

        $query = "
            SELECT p.*, a.id_alat 
            FROM peminjaman p
            JOIN alat a ON p.nama_alat = a.nama_alat
            WHERE p.id_peminjaman = '$id'
        ";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error (getById): " . mysqli_error($this->db));
        }

        return mysqli_fetch_assoc($result);
    }

    // insert ke tabel pengembalian DENGAN denda otomatis
    public function insertPengembalian($data, $kondisi = 'Baik') {
        $id_peminjaman = mysqli_real_escape_string($this->db, $data['id_peminjaman']);
        $id_alat = mysqli_real_escape_string($this->db, $data['id_alat']);
        $kondisi = mysqli_real_escape_string($this->db, $kondisi);

        $tanggal = date('Y-m-d');
        
        // Hitung denda otomatis
        $denda = $this->hitungDenda($data['tanggal_kembali'], $tanggal, $kondisi);

        $query = "
            INSERT INTO pengembalian 
            (id_peminjaman, id_alat, tanggal_dikembalikan, kondisi_kembali, denda)
            VALUES 
            ('$id_peminjaman', '$id_alat', '$tanggal', '$kondisi', '$denda')
        ";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error (insertPengembalian): " . mysqli_error($this->db));
        }

        return $result;
    }

    // Hitung denda otomatis
    public function hitungDenda($tanggal_jatuh_tempo, $tanggal_dikembalikan, $kondisi = 'Baik') {
        $denda = 0;

        // Hitung keterlambatan
        $jatuhTempo = new DateTime($tanggal_jatuh_tempo);
        $dikembalikan = new DateTime($tanggal_dikembalikan);
        
        if ($dikembalikan > $jatuhTempo) {
            $selisih = $jatuhTempo->diff($dikembalikan);
            $hari_terlambat = $selisih->days;
            $denda += $hari_terlambat * DENDA_PER_HARI;
        }

        // Denda kondisi barang
        if (strtolower($kondisi) === 'rusak') {
            $denda += DENDA_RUSAK;
        } elseif (strtolower($kondisi) === 'hilang') {
            $denda += DENDA_HILANG;
        }

        return $denda;
    }

    // update status peminjaman
    public function updateStatus($id) {
        $id = mysqli_real_escape_string($this->db, $id);

        $query = "
            UPDATE peminjaman
            SET status = 'dikembalikan'
            WHERE id_peminjaman = '$id'
        ";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error (updateStatus): " . mysqli_error($this->db));
        }

        return $result;
    }

    // Kembalikan stok alat
    public function restoreStok($nama_alat, $jumlah) {
        $nama_alat = mysqli_real_escape_string($this->db, $nama_alat);
        $jumlah = (int) $jumlah;

        $query = "UPDATE alat SET tersedia = tersedia + $jumlah WHERE nama_alat = '$nama_alat'";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query Error (restoreStok): " . mysqli_error($this->db));
        }

        return $result;
    }
}