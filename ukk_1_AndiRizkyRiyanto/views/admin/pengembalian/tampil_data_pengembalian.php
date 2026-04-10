<?php
session_start();
include_once __DIR__ . '/../../../controllers/c_pengembalian.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$ctrl = new c_pengembalian();
$ctrl->handleAksi();

$data = $ctrl->index();

// 🔍 FITUR CARI
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>
<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<style>
.card {
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.05);
}

.search-box {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
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

/* TABEL */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
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

tr:nth-child(even) { background: #f8fafc; }

.btn-hapus {
  background: #ef4444;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 12px;
}

.text-red {
    color: red;
    font-weight: bold;
}
</style>

<div class="main-content" style="min-height:100vh;">
  <div class="card" style="width:100%;">

    <h2 style="margin-bottom:15px;"><i class="fas fa-rotate-left" style="color:#6366f1; margin-right:8px;"></i>Data Pengembalian</h2>

    <form method="GET" class="search-box">
      <input type="text" name="cari" placeholder="Cari peminjam / alat..." value="<?= htmlspecialchars($cari); ?>">
      <button type="submit"><i class="fas fa-search"></i> Cari</button>
    </form>

    <table>
      <tr>
        <th>No</th>
        <th>Nama Peminjam</th>
        <th>Nama Alat</th>
        <th>Dikembalikan Tgl</th>
        <th>Terlambat (Hari)</th>
        <th>Kondisi</th>
        <th>Denda</th>
        <th>Aksi</th>
      </tr>

      <?php $no = 1; $found = false; ?>

      <?php if ($data && $data->num_rows > 0): ?>
        <?php while ($row = $data->fetch_assoc()): ?>

          <?php
          // 🔍 PENCARIAN NAMA / ALAT
          if ($cari) {
              $matchNama = stripos($row['nama_peminjam'], $cari) !== false;
              $matchAlat = stripos($row['nama_alat'], $cari) !== false;
              if (!$matchNama && !$matchAlat) continue;
          }
          $found = true;

          // Hitung keterlambatan (visual saja, denda asli ada di db)
          $jatuhTempo = new DateTime($row['jatuh_tempo']);
          $dikembalikan = new DateTime($row['tanggal_dikembalikan']);
          $hari_telat = 0;
          if ($dikembalikan > $jatuhTempo) {
             $selisih = $jatuhTempo->diff($dikembalikan);
             $hari_telat = $selisih->days;
          }
          ?>

          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_peminjam'] ?></td>
            <td><?= $row['nama_alat'] ?></td>
            <td><?= $row['tanggal_dikembalikan'] ?></td>
            <td <?= $hari_telat > 0 ? 'class="text-red"' : '' ?>><?= $hari_telat ?> hari</td>
            <td><?= $row['kondisi_kembali'] ?></td>
            <td <?= $row['denda'] > 0 ? 'class="text-red"' : '' ?>>Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
            <td>
              <a href="?hapus=<?= $row['id_pengembalian'] ?>"
                 class="btn-hapus"
                 onclick="return confirm('Hapus riwayat pengembalian ini?')"><i class="fas fa-trash"></i> Hapus</a>
            </td>
          </tr>

        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="8">Belum ada data pengembalian</td>
        </tr>
      <?php endif; ?>

      <?php if (!$found && $data && $data->num_rows > 0): ?>
        <tr>
          <td colspan="8">Data tidak ditemukan</td>
        </tr>
      <?php endif; ?>
    </table>

  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>