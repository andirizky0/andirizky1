<?php
include __DIR__ . '/../../../controllers/c_alat.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$c_alat = new c_alat();

$pesan = "";

// PROSES TAMBAH
if (isset($_POST['tambah'])) {

    $nama = trim($_POST['nama']);
    $stok = trim($_POST['stok']);
    $tersedia = trim($_POST['tersedia']);
    $kondisi = trim($_POST['kondisi']);

    // VALIDASI
    if ($nama == "" || $stok == "" || $tersedia == "" || $kondisi == "") {
        $pesan = "❌ Data belum lengkap, silakan isi semua field!";
    } else {

        // kirim ke controller
        $_POST['tambah'] = true;
        $c_alat->handleAksi();

        echo "<script>
                alert('✅ Data berhasil ditambahkan!');
                window.location='" . BASE_URL . "views/admin/alat/tampil_data_alat.php';
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Alat</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f1f5f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    background: #ffffff;
    padding: 30px;
    border-radius: 14px;
    width: 360px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #1e293b;
}

label {
    font-weight: 600;
    font-size: 14px;
}

input, select {
    width: 100%;
    padding: 9px 12px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background: #1e3a8a;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #1e40af;
}

.btn-kembali {
    display: block;
    text-align: center;
    margin-top: 10px;
    text-decoration: none;
    color: #ef4444;
    font-weight: 600;
}

.pesan {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 6px;
    font-size: 13px;
    background: #fee2e2;
    color: #991b1b;
    text-align: center;
}
</style>

<script>
function konfirmasiSimpan() {
    return confirm("Yakin data sudah benar?");
}
</script>

</head>
<body>

<div class="card">
    <h2><i class="fas fa-plus-circle" style="color:#6366f1; margin-right:8px;"></i>Tambah Data Alat</h2>

    <?php if ($pesan != ""): ?>
        <div class="pesan"><?= $pesan; ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Nama Alat</label>
        <input type="text" name="nama" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>">

        <label>Stok</label>
        <input type="number" name="stok" value="<?= isset($_POST['stok']) ? $_POST['stok'] : '' ?>">

        <label>Tersedia</label>
        <input type="number" name="tersedia" value="<?= isset($_POST['tersedia']) ? $_POST['tersedia'] : '' ?>">

        <label>Kondisi</label>
        <select name="kondisi">
            <option value="">-- Pilih --</option>
            <option value="baik" <?= (isset($_POST['kondisi']) && $_POST['kondisi']=="baik") ? "selected" : "" ?>>Baik</option>
            <option value="rusak" <?= (isset($_POST['kondisi']) && $_POST['kondisi']=="rusak") ? "selected" : "" ?>>Rusak</option>
        </select>

        <button type="submit" name="tambah" onclick="return konfirmasiSimpan()"><i class="fas fa-save"></i> Simpan</button>

    </form>

    <!-- ✅ FIX 100% KEMBALI -->
    <a href="<?= BASE_URL ?>views/admin/alat/tampil_data_alat.php" class="btn-kembali"><i class="fas fa-arrow-left"></i> Kembali</a>

</div>

</body>
</html>