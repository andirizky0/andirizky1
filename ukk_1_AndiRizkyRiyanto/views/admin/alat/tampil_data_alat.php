<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../../../controllers/c_alat.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$c_alat = new c_alat();
$c_alat->handleAksi();
$data = $c_alat->index();

// 🔍 FITUR CARI
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>
<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<style>
/* ===== CARD ===== */
.card {
  background: #fff;
  padding: 25px;
  border-radius: 14px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

/* ===== SEARCH ===== */
.search-box {
  margin-bottom: 15px;
  display: flex;
  gap: 10px;
}

.search-box input {
  padding: 8px 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
  width: 250px;
}

.search-box button {
  padding: 8px 14px;
  border: none;
  background: #1e3a8a;
  color: white;
  border-radius: 6px;
  cursor: pointer;
}

.search-box button:hover {
  background: #172554;
}

/* ===== TABLE ===== */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 14px;
}

table th {
  background: #1e3a8a;
  padding: 14px 10px;
  text-align: center;
  font-weight: 600;
  color: white;
}

table td {
  padding: 13px 10px;
  text-align: center;
  color: #475569;
  border-bottom: 1px solid #e5e7eb;
}

table tr:nth-child(even) {
  background: #f8fafc;
}

table tr:hover {
  background: #e0f2fe;
  transition: 0.2s;
}

/* ===== AKSI ===== */
.aksi-btn {
  display: flex;
  flex-direction: column;
  gap: 6px;
  align-items: center;
}

.aksi-btn a {
  width: 70px;
  text-align: center;
}

/* ===== BUTTON ===== */
.btn-edit {
  background: #3b82f6;
  color: white;
  padding: 6px 0;
  border-radius: 6px;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
}

.btn-edit:hover {
  background: #2563eb;
}

.btn-hapus {
  background: #ef4444;
  color: white;
  padding: 6px 0;
  border-radius: 6px;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
}

.btn-hapus:hover {
  background: #dc2626;
}

.btn-tambah {
  background: linear-gradient(90deg, #22c55e, #16a34a);
  color: white;
  padding: 9px 16px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 600;
}

.btn-tambah:hover {
  opacity: 0.9;
}
</style>

<div class="main-content">

  <div class="header" style="background: white; padding: 15px; border-radius: 10px; display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h3><i class="fas fa-tools" style="color:#6366f1; margin-right:8px;"></i>Data Alat</h3>
    <div style="display:flex; gap:18px; align-items:center;">
      <div><i class="fas fa-cubes" style="color:#6366f1;"></i> Total: <b><?= $data['total_alat']; ?></b></div>
      <a href="<?= BASE_URL ?>views/admin/alat/tambah.php" class="btn-tambah"><i class="fas fa-plus"></i> Tambah Alat</a>
    </div>
  </div>

  <div class="card">

    <!-- 🔍 FORM CARI -->
    <form method="GET" class="search-box">
      <input type="text" name="cari" placeholder="Cari nama alat..." value="<?= htmlspecialchars($cari); ?>">
      <button type="submit"><i class="fas fa-search"></i> Cari</button>
    </form>

    <table>
      <tr>
        <th>No</th>
        <th>Nama Alat</th>
        <th>Stok</th>
        <th>Tersedia</th>
        <th>Kondisi</th>
        <th>Aksi</th>
      </tr>

      <?php 
      $no = 1; 
      $found = false; // 🔥 penanda data ditemukan
      ?>

      <?php if (mysqli_num_rows($data['alat']) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($data['alat'])): ?>

          <?php
          // 🔍 FILTER DATA
          if ($cari && stripos($row['nama_alat'], $cari) === false) {
              continue;
          }
          $found = true;
          ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_alat']); ?></td>
            <td><?= $row['stok']; ?></td>
            <td><?= $row['tersedia']; ?></td>
            <td><?= htmlspecialchars($row['kondisi']); ?></td>
            <td>
              <div class="aksi-btn">
                <a href="<?= BASE_URL ?>views/admin/alat/edit_alat.php?id=<?= $row['id_alat']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="?hapus=<?= $row['id_alat']; ?>"
                   class="btn-hapus"
                   onclick="return confirm('Yakin mau hapus alat ini?')">
                   <i class="fas fa-trash"></i> Hapus
                </a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>

        <!-- 🔥 JIKA TIDAK ADA HASIL PENCARIAN -->
        <?php if (!$found): ?>
          <tr>
            <td colspan="6">Data tidak ditemukan</td>
          </tr>
        <?php endif; ?>

      <?php else: ?>
        <tr>
          <td colspan="6">Data alat kosong</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>

</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>