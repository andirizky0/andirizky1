<?php
session_start();
include_once __DIR__ . '/../../../controllers/c_kategori.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';

$controller = new c_kategori();
$controller->handleAksi();
$data = $controller->index();

// 🔍 FITUR CARI
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>
<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:Arial, sans-serif;
}

.main-content{
  padding:20px;
  background:#f1f5f9;
  min-height:100vh;
}

.page-title{
  font-size:20px;
  font-weight:600;
  margin-bottom:18px;
}

.card{
  background:#ffffff;
  padding:25px;
  border-radius:14px;
  box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* 🔍 SEARCH */
.search-box{
  display:flex;
  gap:10px;
  margin-bottom:15px;
}

.search-box input{
  flex:1;
  padding:10px 12px;
  border-radius:8px;
  border:1px solid #cbd5e1;
  font-size:14px;
}

.search-box button{
  background:#1e3a8a;
  color:white;
  border:none;
  padding:10px 16px;
  border-radius:8px;
  font-size:14px;
  font-weight:600;
  cursor:pointer;
}

.search-box button:hover{
  background:#172554;
}

/* FORM TAMBAH */
.form-inline{
  display:flex;
  gap:10px;
  margin-bottom:18px;
}

.form-inline input{
  flex:1;
  padding:10px 12px;
  border-radius:8px;
  border:1px solid #cbd5e1;
  font-size:14px;
}

.form-inline button{
  background:linear-gradient(90deg, #22c55e, #16a34a);
  color:white;
  border:none;
  padding:10px 16px;
  border-radius:8px;
  font-size:14px;
  font-weight:600;
  cursor:pointer;
}

.form-inline button:hover{
  opacity:0.9;
}

.table{
  width:100%;
  border-collapse:collapse;
  font-size:14px;
}

.table th{
  background:#1e3a8a;
  color:white;
  padding:14px 10px;
  text-align:center;
  font-weight:600;
}

.table td{
  padding:12px 10px;
  text-align:center;
  color:#475569;
  border-bottom:1px solid #e5e7eb;
}

.table tr:nth-child(even){
  background:#f8fafc;
}

.table tr:hover{
  background:#e0f2fe;
  transition:0.2s;
}

.aksi-btn{
  display:flex;
  flex-direction:column;
  gap:6px;
  align-items:center;
}

.aksi-btn a{
  width:70px;
  text-align:center;
}

.btn-edit{
  background:#3b82f6;
  color:white;
  padding:6px 0;
  border-radius:6px;
  text-decoration:none;
  font-size:13px;
  font-weight:500;
}

.btn-edit:hover{
  background:#2563eb;
}

.btn-hapus{
  background:#ef4444;
  color:white;
  padding:6px 0;
  border-radius:6px;
  text-decoration:none;
  font-size:13px;
  font-weight:500;
}

.btn-hapus:hover{
  background:#dc2626;
}
</style>

<script>
function confirmTambah(){
    return confirm("Apakah data sudah benar dan ingin ditambahkan?");
}
</script>

<div class="main-content">
  <div class="content">

    <div class="page-title"><i class="fas fa-folder-open" style="color:#6366f1; margin-right:8px;"></i>Data Kategori</div>

    <div class="card">

      <!-- 🔍 FORM CARI -->
      <form method="GET" class="search-box">
        <input type="text" name="cari" placeholder="Cari kategori..." value="<?= htmlspecialchars($cari); ?>">
        <button type="submit"><i class="fas fa-search"></i> Cari</button>
      </form>

      <!-- FORM TAMBAH -->
      <form class="form-inline" method="POST">
        <input
          type="text"
          name="nama_kategori"
          placeholder="Masukkan nama kategori"
          required
        >
        <button type="submit" name="tambah" onclick="return confirmTambah()"><i class="fas fa-plus"></i> Tambah</button>
      </form>

      <!-- TABEL -->
      <table class="table">
        <tr>
          <th>No</th>
          <th>Nama Kategori</th>
          <th>Aksi</th>
        </tr>

        <?php 
        $no = 1; 
        $found = false; 
        ?>

        <?php if (!empty($data)) : ?>
          <?php foreach ($data as $row) : ?>

            <?php
            // 🔍 FILTER
            if ($cari && stripos($row['nama_kategori'], $cari) === false) {
                continue;
            }
            $found = true;
            ?>

            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
              <td>
                <div class="aksi-btn">
                  <a href="<?= BASE_URL ?>views/admin/kategori/edit_kategori.php?id=<?= $row['id_kategori']; ?>" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="?hapus=<?= $row['id_kategori']; ?>"
                     class="btn-hapus"
                     onclick="return confirm('Yakin hapus data ini?')">
                    <i class="fas fa-trash"></i> Hapus
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <!-- 🔥 JIKA TIDAK ADA HASIL -->
          <?php if (!$found): ?>
            <tr>
              <td colspan="3">Data tidak ditemukan</td>
            </tr>
          <?php endif; ?>

        <?php else : ?>
          <tr>
            <td colspan="3">Data kategori belum ada</td>
          </tr>
        <?php endif; ?>
      </table>

    </div>

  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>