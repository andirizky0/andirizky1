<?php
session_start();
include_once __DIR__ . '/../../controllers/c_mengajukan.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

$c = new c_mengajukan();
$c->proses();

$data = $c->index();
$nama_alat_diajukan = $_GET['ajukan'] ?? '';
$nama_user = $_SESSION['nama'] ?? 'Peminjam';
?>

<?php include __DIR__ . '/../layout/header.php'; ?>
<?php include __DIR__ . '/../layout/sidebar.php'; ?>

<style>

/* ================= GLOBAL ================= */
.main-content {
  padding: 20px;
  background: #eef2f7;
  min-height: 100vh;
}

/* ================= TITLE ================= */
.title {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 10px;
}

/* ================= CATEGORY ================= */
.category-bar {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  overflow-x: auto;
}

.category-btn {
  padding: 8px 15px;
  border-radius: 20px;
  background: #fff;
  font-size: 13px;
  border: 1px solid #ddd;
  cursor: pointer;
  white-space: nowrap;
  transition: 0.3s;
}

.category-btn.active {
  background: #3498db;
  color: #fff;
  border: none;
}

/* ================= CARD ================= */
.cards-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
}

@media (max-width: 500px) {
  .cards-grid {
    grid-template-columns: 1fr;
  }
}

.card-item {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  transition: 0.3s;
  position: relative;
}

.card-item:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* love icon */
.card-item .love {
  position: absolute;
  top: 8px;
  right: 8px;
  background: #fff;
  padding: 6px;
  border-radius: 50%;
  font-size: 13px;
}

/* badge */
.badge {
  position: absolute;
  top: 8px;
  left: 8px;
  background: #27ae60;
  color: white;
  font-size: 10px;
  padding: 3px 6px;
  border-radius: 5px;
}

.card-item img {
  width: 100%;
  height: 140px;
  object-fit: cover;
}

.card-info {
  padding: 12px;
}

.card-info h4 {
  font-size: 14px;
  margin-bottom: 5px;
}

/* stok */
.stok {
  font-size: 12px;
  color: #666;
}

/* tombol */
.btn {
  display: inline-block;
  margin-top: 8px;
  padding: 6px 12px;
  background: #3498db;
  color: #fff;
  border-radius: 20px;
  text-decoration: none;
  font-size: 12px;
}

.btn:hover {
  background: #2980b9;
}

/* ================= FORM ================= */
.form-box {
  max-width: 420px;
  margin: 40px auto;
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.form-box h2 {
  text-align: center;
  margin-bottom: 15px;
}

.form-box img {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 15px;
}

.form-box label {
  display: block;
  margin-top: 10px;
  font-weight: 600;
  font-size: 13px;
}

.form-box input {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ddd;
  border-radius: 6px;
}

.form-box button {
  width: 100%;
  margin-top: 15px;
  padding: 10px;
  background: #27ae60;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 15px;
  color: #3498db;
}

</style>

<div class="main-content">

<?php if (!$nama_alat_diajukan): ?>

  <div class="title"><i class="fas fa-mountain" style="color:#6366f1; margin-right:8px;"></i>Daftar Alat Gunung</div>

  <!-- CATEGORY -->
  <div class="category-bar">
    <div class="category-btn active" data-filter="semua"><i class="fas fa-th-large"></i> Semua</div>
    <div class="category-btn" data-filter="perlengkapan gunung"><i class="fas fa-mountain"></i> Perlengkapan Gunung</div>
    <div class="category-btn" data-filter="perlengkapan tidur"><i class="fas fa-campground"></i> Perlengkapan Tidur</div>
    <div class="category-btn" data-filter="perlengkapan masak"><i class="fas fa-fire"></i> Perlengkapan Masak</div>
  </div>

  <div class="cards-grid">

    <?php if ($data && mysqli_num_rows($data) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($data)): ?>

        <?php
        $fileName = strtolower(str_replace(' ', '_', $row['nama_alat'])) . '.png';
        $imgPath = "../../assets/img/alat/" . $fileName;
        $realImgPath = BASE_URL . "assets/img/alat/" . $fileName;
        $defaultImgPath = BASE_URL . "assets/img/default.png";

        if (!file_exists(__DIR__ . "/../../assets/img/alat/" . $fileName)) {
            $imgSrc = $defaultImgPath;
        } else {
            $imgSrc = $realImgPath;
        }

        // Tentukan kategori (fallback jika di database null)
        $namaAlat = strtolower($row['nama_alat']);
        $kategori = strtolower($row['nama_kategori'] ?? '');
        if (empty($kategori)) {
            if (in_array($namaAlat, ['carrier', 'sepatu', 'jas hujan', 'hadlamp', 'headlamp'])) {
                $kategori = 'perlengkapan gunung';
            } elseif (in_array($namaAlat, ['tenda dome', 'sleeping bag standar', 'matras camping', 'sleeping bag', 'matras'])) {
                $kategori = 'perlengkapan tidur';
            } elseif (in_array($namaAlat, ['kompor portable', 'gas portable', 'nesting'])) {
                $kategori = 'perlengkapan masak';
            }
        }
        ?>

        <div class="card-item" data-kategori="<?= htmlspecialchars($kategori) ?>">
          <?php if($row['tersedia'] > 0): ?>
             <div class="badge">Ready</div>
          <?php else: ?>
             <div class="badge" style="background:#e74c3c">Habis</div>
          <?php endif; ?>
          
          <div class="love">❤️</div>

          <img src="<?= $imgSrc ?>">

          <div class="card-info">
            <h4><?= htmlspecialchars($row['nama_alat']) ?></h4>

            <div class="stok">Tersedia: <?= $row['tersedia'] ?> / <?= $row['stok'] ?></div>
            <div class="stok">Kondisi: <?= $row['kondisi'] ?></div>

            <?php if($row['tersedia'] > 0): ?>
                <a class="btn" href="?ajukan=<?= urlencode($row['nama_alat']) ?>"><i class="fas fa-paper-plane"></i> Ajukan</a>
            <?php else: ?>
                <span class="btn" style="background:#7f8c8d; cursor:not-allowed"><i class="fas fa-ban"></i> Habis</span>
            <?php endif; ?>
          </div>
        </div>

      <?php endwhile; ?>
    <?php endif; ?>

  </div>

<?php else: ?>

  <?php
  $fileName = strtolower(str_replace(' ', '_', $nama_alat_diajukan)) . '.png';
  $realImgPath = BASE_URL . "assets/img/alat/" . $fileName;
  $defaultImgPath = BASE_URL . "assets/img/default.png";

  if (!file_exists(__DIR__ . "/../../assets/img/alat/" . $fileName)) {
      $imgSrc = $defaultImgPath;
  } else {
      $imgSrc = $realImgPath;
  }
  ?>

  <div class="form-box">
    <h2><i class="fas fa-clipboard-list" style="color:#6366f1;"></i> Tambah Peminjaman</h2>

    <img src="<?= $imgSrc ?>">

    <form method="POST">
      <input type="hidden" name="nama_alat" value="<?= htmlspecialchars($nama_alat_diajukan) ?>">
      <input type="hidden" name="nama_peminjam" value="<?= htmlspecialchars($nama_user) ?>">

      <label>Nama Peminjam</label>
      <input type="text" value="<?= htmlspecialchars($nama_user) ?>" readonly>

      <label>Alat</label>
      <input type="text" value="<?= htmlspecialchars($nama_alat_diajukan) ?>" readonly>

      <label>Tanggal Pinjam</label>
      <input type="date" name="tanggal_pinjam" required>

      <label>Tanggal Kembali</label>
      <input type="date" name="tanggal_kembali" required>

      <label>Jumlah</label>
      <input type="number" name="jumlah" min="1" required>

      <label>Keterangan / Ukuran</label>
      <input type="text" name="ukuran" placeholder="Opsional (misal: size L)">

      <button type="submit" name="simpan"><i class="fas fa-save"></i> Simpan</button>
    </form>

    <a href="mengajukan.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>

<?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.category-btn');
    const cards = document.querySelectorAll('.card-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active from all buttons
            buttons.forEach(b => b.classList.remove('active'));
            // Add active to clicked button
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');

            cards.forEach(card => {
                if (filter === 'semua' || card.getAttribute('data-kategori') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>