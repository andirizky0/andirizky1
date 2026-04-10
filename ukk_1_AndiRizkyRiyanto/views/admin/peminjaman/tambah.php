<?php
include_once __DIR__ . '/../../../controllers/c_peminjaman.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$controller = new c_peminjaman();

if (isset($_POST['simpan'])) {
    $result = $controller->tambah($_POST);
    if ($result) {
        echo "<script>
                alert('Peminjaman berhasil ditambahkan!');
                window.location.href='" . BASE_URL . "views/admin/peminjaman/tampil_data_peminjaman.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan peminjaman! Cek data yang diinput.');
                history.back();
              </script>";
    }
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

.card-form {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card-form h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #1e293b;
}

.input-grup { margin-bottom: 15px; }

.input-grup label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #475569;
}

.input-grup input,
.input-grup textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    outline: none;
    font-family: inherit;
}

.input-grup input:focus,
.input-grup textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

.btn-grup {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.btn-submit {
    background: #1e3a8a;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover { background: #1e40af; }

.btn-kembali {
    text-align: center;
    text-decoration: none;
    color: #ef4444;
    font-weight: 600;
    font-size: 14px;
}
</style>

<div class="main-content">
  <div class="card-form">
    <h3><i class="fas fa-plus-circle" style="color:#6366f1; margin-right:8px;"></i>Tambah Peminjaman</h3>

    <form method="POST">
      <div class="input-grup">
        <label>Nama Peminjam</label>
        <input type="text" name="nama_peminjam" required>
      </div>

      <div class="input-grup">
        <label>Nama Alat</label>
        <input type="text" name="nama_alat" required>
      </div>

      <div style="display:flex; gap:10px;">
        <div class="input-grup" style="flex:1;">
          <label>Tgl Pinjam</label>
          <input type="date" name="tanggal_pinjam" required>
        </div>
        <div class="input-grup" style="flex:1;">
          <label>Tgl Kembali</label>
          <input type="date" name="tanggal_kembali" required>
        </div>
      </div>

      <div class="input-grup">
        <label>Jumlah</label>
        <input type="number" name="jumlah" required>
      </div>

      <div class="input-grup">
        <label>Keterangan</label>
        <textarea name="keterangan" rows="3"></textarea>
      </div>

      <div class="btn-grup">
        <button type="submit" name="simpan" class="btn-submit"><i class="fas fa-save"></i> Simpan Peminjaman</button>
        <a href="<?= BASE_URL ?>views/admin/peminjaman/tampil_data_peminjaman.php" class="btn-kembali"><i class="fas fa-arrow-left"></i> Batal</a>
      </div>
    </form>
  </div>
</div>