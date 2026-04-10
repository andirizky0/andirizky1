<?php
include_once __DIR__ . '/../../../controllers/c_kategori.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$controller = new c_kategori();

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "views/admin/kategori/tampil_data_kategori.php");
    exit;
}

$id = $_GET['id'];
$data = $controller->getById($id);

// Proses Update
if (isset($_POST['update'])) {
    $nama = $_POST['nama_kategori'];
    $controller->update($id, $nama);
    echo "<script>
            alert('Berhasil perbarui kategori');
            window.location.href='" . BASE_URL . "views/admin/kategori/tampil_data_kategori.php';
          </script>";
}
?>

<style>
/* CSS UNTUK CENTER FORM */
.main-content {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f1f5f9;
}

.card-center {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    width: 380px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card-center h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #1e293b;
}

.input-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #475569;
}

.input-group input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    outline: none;
}

.input-group input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

.btn-group {
    margin-top: 25px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-update {
    background: #1e3a8a;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.btn-update:hover {
    background: #1e40af;
}

.btn-kembali {
    text-align: center;
    text-decoration: none;
    color: #ef4444;
    font-weight: 600;
    font-size: 14px;
}
</style>

<div class="main-content">
  <div class="card-center">
    <h3><i class="fas fa-edit" style="color:#6366f1; margin-right:8px;"></i>Edit Kategori</h3>

    <form method="POST">
      <div class="input-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required>
      </div>

      <div class="btn-group">
        <button type="submit" name="update" class="btn-update"><i class="fas fa-save"></i> Perbarui</button>
        <a href="<?= BASE_URL ?>views/admin/kategori/tampil_data_kategori.php" class="btn-kembali"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</div>