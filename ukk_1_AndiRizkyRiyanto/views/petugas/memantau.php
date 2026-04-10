<?php
session_start();
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../controllers/c_memantau.php';

$c = new c_memantau();
$data = $c->index();
?>

<?php include_once __DIR__ . '/../layout/header.php'; ?>
<?php include_once __DIR__ . '/../layout/sidebar.php'; ?>

<style>
.main-content {
  padding: 20px;
}

.box {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

/* ===== TABLE ===== */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

th {
  background: #1e3a8a; /* DISAMAKAN DENGAN HEADER / SIDEBAR */
  color: white;
  padding: 14px 10px;
  text-align: center;
}

td {
  padding: 12px 10px;
  border-bottom: 1px solid #e5e7eb;
  text-align: center;
  color: #475569;
}

tr:nth-child(even) {
  background: #f8fafc;
}

tr:hover {
  background: #e0f2fe;
}

/* ===== STATUS ===== */
.dipinjam {
  color: #2563eb;
  font-weight: 600;
}

.terlambat {
  color: #ef4444;
  font-weight: 600;
}

.kembali {
  color: #10b981;
  font-weight: 600;
}

.ditolak {
  color: #64748b;
  font-weight: 600;
}
.text-red {
    color: #ef4444;
}
</style>

<div class="main-content">
  <div class="box">

    <h2 style="margin-bottom:15px;"><i class="fas fa-eye" style="color:#6366f1; margin-right:8px;"></i> Memantau Pengembalian</h2>

    <table>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alat</th>
        <th>Tgl Pinjam</th>
        <th>Jatuh Tempo</th>
        <th>Status</th>
        <th>Tgl Dikembalikan</th>
      </tr>

      <?php if ($data && $data->num_rows > 0): ?>
        <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
          <td><?= htmlspecialchars($row['nama_alat']) ?></td>
          <td><?= $row['tanggal_pinjam'] ?></td>
          <td><?= $row['tanggal_kembali'] ?></td>

          <td>
            <?php
            // Hitung denda otomatis untuk visualisasi
            $jatuhTempo = new DateTime($row['tanggal_kembali']);
            $hr_ini = new DateTime(date('Y-m-d'));
            
            if ($row['status'] == 'dipinjam' && $hr_ini > $jatuhTempo) {
                $selisih = $jatuhTempo->diff($hr_ini);
                $hari_telat = $selisih->days;
                echo "<span class='terlambat'>Terlambat ($hari_telat hari)</span>";
            } elseif ($row['status'] == 'dipinjam') {
                echo "<span class='dipinjam'>Dipinjam</span>";
            } elseif ($row['status'] == 'terlambat') {
                echo "<span class='terlambat'>Terlambat</span>";
            } elseif ($row['status'] == 'ditolak') {
                 echo "<span class='ditolak'>Ditolak</span>";
            } else {
                 echo "<span class='kembali'>Dikembalikan</span>";
            }
            ?>
          </td>

          <td>
            <?= $row['tgl_kembali_real'] ? $row['tgl_kembali_real'] : '-' ?>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">Tidak ada data</td>
        </tr>
      <?php endif; ?>
    </table>

  </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>