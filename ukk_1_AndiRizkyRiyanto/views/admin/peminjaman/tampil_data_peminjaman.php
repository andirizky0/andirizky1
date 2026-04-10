<?php
session_start();
include_once __DIR__ . '/../../../controllers/c_peminjaman.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$c_peminjaman = new c_peminjaman();
$data = $c_peminjaman->index();

// 🔍 FITUR CARI
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>
<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<style>
/* MATIKAN SCROLL BODY PADA LAYAR KECIL JIKA DIPERLUKAN */
.main-content {
  padding: 20px;
  background: #f1f5f9;
  min-height: 100vh;
}

/* KOTAK PUTIH UTAMA UTK KONTEN */
.card {
  background: #ffffff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
}

/* ----- 🔍 SEARCH & TOMBOL TAMBAH DIBUAT SEJAJAR ----- */
.toolbar-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;       /* Agar di layar kecil bisa turun ke bawah */
  gap: 15px;             /* Jarak kalau terpaksa turun */
}

.search-box {
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

/* TOMBOL TAMBAH PINJAMAN KANAN */
.btn-tambah {
  background: #22c55e;
  color: white;
  padding: 9px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: 0.3s;
}

.btn-tambah:hover {
  background: #16a34a;
}

/* ----- WRAPPER TABEL (WAJIB ADA AGAR BISA SCROLL MENDATAR) ----- */
.table-responsive {
  width: 100%;
  overflow-x: auto;
  border-radius: 8px; /* Biar sudut tabel tidak tajam */
}

/* TABEL */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
  min-width: 800px; /* Lebar minimum tabel agar tidak hancur */
}

th {
  background: #1e3a8a;
  color: white;
  padding: 12px;
  text-align: center;
}

td {
  padding: 12px;
  text-align: center;
  border-bottom: 1px solid #e5e7eb;
}

tr:nth-child(even) {
  background: #f8fafc;
}

/* BADGES STATUS */
.badge {
  padding: 5px 10px;
  border-radius: 5px;
  font-size: 12px;
  color: white;
  font-weight: bold;
}

.badge.menunggu { background: #f59e0b; }
.badge.dipinjam { background: #3b82f6; }
.badge.terlambat { background: #ef4444; }
.badge.dikembalikan { background: #10b981; }

/* AKSI BTN */
.aksi-btn {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.btn-edit, .btn-hapus {
  padding: 5px 0;
  width: 60px;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 12px;
  margin: 0 auto;
}

.btn-edit { background: #3b82f6; }
.btn-hapus { background: #ef4444; }

/* =========== RESPONSIVE LAYAR HP =========== */
@media screen and (max-width: 768px) {
  /* Search & Tambah jd numpuk kalau terdesak */
  .toolbar-wrap {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>


<div class="main-content">
  <div class="card">

    <!-- BUNGKUSAN SEARCH DAN TOMBOL TAMBAH -->
    <div class="toolbar-wrap">
      <form method="GET" class="search-box">
        <input type="text" name="cari" placeholder="Cari peminjam..." value="<?= htmlspecialchars($cari); ?>">
        <button type="submit"><i class="fas fa-search"></i> Cari</button>
      </form>

      <a href="<?= BASE_URL ?>views/admin/peminjaman/tambah.php" class="btn-tambah"><i class="fas fa-plus"></i> Tambah Pinjaman</a>
    </div>

    <!-- WRAPPER TABEL (UNTUK SCROLL HORIZONTAL) -->
    <div class="table-responsive">
      <table>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Alat</th>
          <th>Pinjam</th>
          <th>Kembali</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>

        <?php 
        $no = 1; 
        $found = false;
        ?>

        <?php while ($row = mysqli_fetch_assoc($data)) : ?>

          <?php
          // 🔍 FILTER BY NAMA PEMINJAM
          if ($cari && stripos($row['nama_peminjam'], $cari) === false) {
              continue;
          }
          $found = true;
          ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_peminjam']); ?></td>
            <td><?= htmlspecialchars($row['nama_alat']); ?></td>
            <td><?= $row['tanggal_pinjam']; ?></td>
            <td><?= $row['tanggal_kembali']; ?></td>
            <td><?= $row['jumlah']; ?></td>
            <td><?= htmlspecialchars($row['keterangan'] ?? ''); ?></td>
            <td>
              <span class="badge <?= strtolower($row['status']); ?>">
                <?= ucfirst($row['status']); ?>
              </span>
            </td>
            <td>
              <div class="aksi-btn">
                <a href="<?= BASE_URL ?>views/admin/peminjaman/edit.php?id=<?= $row['id_peminjaman']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="<?= BASE_URL ?>controllers/c_peminjaman.php?aksi=hapus&id=<?= $row['id_peminjaman']; ?>" 
                   class="btn-hapus"
                   onclick="return confirm('Hapus data peminjaman ini?')"><i class="fas fa-trash"></i> Hapus</a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>

        <?php if (!$found): ?>
          <tr>
            <td colspan="9">Data tidak ditemukan</td>
          </tr>
        <?php endif; ?>

      </table>
    </div>

  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>