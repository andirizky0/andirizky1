<?php
include __DIR__ . '/../../../controllers/c_alat.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$c_alat = new c_alat();

// Jalankan proses update kalau tombol ditekan
$c_alat->handleAksi();

// Ambil id dari URL
$id = $_GET['id'] ?? 0;

// Ambil data berdasarkan id lewat controller
$result = $c_alat->getById($id);
$data = mysqli_fetch_assoc($result);

// Kalau data tidak ditemukan
if(!$data){
    echo "Data tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Alat</title>

    <style>
/* BACKGROUND PUTIH */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f1f5f9;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* CARD */
.container {
    width: 420px;
    margin: 60px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* TITLE */
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #1e293b;
}

/* LABEL */
label {
    font-weight: 600;
    color: #334155;
}

/* INPUT */
input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 18px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: 0.2s;
}

input:focus,
select:focus {
    border-color: #1e3a8a;
    outline: none;
    box-shadow: 0 0 5px rgba(30,58,138,0.3);
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    background: #1e3a8a;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #1e40af;
}

/* BUTTON BATAL */
.btn-cancel {
    display: block;
    text-align: center;
    margin-top: 12px;
    text-decoration: none;
    color: #ef4444;
    font-weight: bold;
}

.btn-cancel:hover {
    text-decoration: underline;
}
    </style>
</head>

<body>

<div class="container">
    <h2><i class="fas fa-edit" style="color:#6366f1; margin-right:8px;"></i>Edit Data Alat</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $data['id_alat']; ?>">

        <label>Nama Alat</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_alat']); ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" required>

        <label>Tersedia</label>
        <input type="number" name="tersedia" value="<?= $data['tersedia']; ?>" required>

        <label>Kondisi</label>
        <select name="kondisi">
            <option value="baik" <?= $data['kondisi']=='baik'?'selected':''; ?>>Baik</option>
            <option value="rusak" <?= $data['kondisi']=='rusak'?'selected':''; ?>>Rusak</option>
        </select>

        <button type="submit" name="edit"><i class="fas fa-save"></i> Update</button>
        <a href="<?= BASE_URL ?>views/admin/alat/tampil_data_alat.php" class="btn-cancel"><i class="fas fa-arrow-left"></i> Batal</a>
    </form>
</div>

</body>
</html>