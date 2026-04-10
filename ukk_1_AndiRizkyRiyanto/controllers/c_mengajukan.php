<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../models/m_mengajukan.php';

/* TAMBAHAN LOG */
include_once __DIR__ . '/../models/m_koneksi.php';
include_once __DIR__ . '/c_log_aktivitas.php';

class c_mengajukan {
    private $model;

    /* TAMBAHAN */
    private $log;

    public function __construct() {
        $this->model = new m_mengajukan();

        /* TAMBAHAN */
        $koneksi = new m_koneksi();
        $this->log = new c_log_aktivitas($koneksi);
    }

    // ambil daftar alat
    public function index() {
        return $this->model->getAlat();
    }

    // proses simpan pengajuan
    public function proses() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {

            $nama     = trim($_POST['nama_peminjam'] ?? '');
            $alat     = trim($_POST['nama_alat'] ?? '');
            $jumlah   = (int)($_POST['jumlah'] ?? 0);
            $ukuran   = trim($_POST['ukuran'] ?? '');
            $pinjam   = $_POST['tanggal_pinjam'] ?? '';
            $kembali  = $_POST['tanggal_kembali'] ?? '';

            if ($nama === '' || $alat === '' || $jumlah <= 0 || $pinjam === '' || $kembali === '') {
                echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
                exit;
            }

            $id = $this->model->simpan([
                'nama_peminjam'   => $nama,
                'nama_alat'       => $alat,
                'jumlah'          => $jumlah,
                'ukuran'          => $ukuran,
                'tanggal_pinjam'  => $pinjam,
                'tanggal_kembali' => $kembali,
                'status'          => 'menunggu'
            ]);

            if (!$id) die("Gagal menyimpan pengajuan!");

            // simpan nama peminjam di session
            $_SESSION['nama'] = $nama;

            /* LOG AKTIVITAS */
            $this->log->tambah($nama, "Mengajukan peminjaman alat: $alat (jumlah: $jumlah)");

            // redirect ke halaman kembalikan.php
            header("Location: " . BASE_URL . "views/peminjam/kembalikan.php?success=1");
            exit;
        }
    }
}
?>