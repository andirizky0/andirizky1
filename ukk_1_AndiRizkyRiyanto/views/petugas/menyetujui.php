<?php
session_start();
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../controllers/c_menyetujui.php';

$c = new c_menyetujui();
$c->proses();
$data = $c->index();
?>

<?php include __DIR__ . '/../layout/header.php'; ?>
<?php include __DIR__ . '/../layout/sidebar.php'; ?>

<style>
.container {
  padding: 25px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

/* ===== TABLE ===== */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

th {
  background: #1e3a8a; /* DISAMAKAN DENGAN HEADER & SIDEBAR */
  color: white;
  padding: 14px 10px;
  text-align: center;
}

td {
  padding: 12px 10px;
  text-align: center;
  border-bottom: 1px solid #e5e7eb;
  color: #475569;
}

tr:nth-child(even) {
  background: #f8fafc;
}

tr:hover {
  background: #e0f2fe;
}

/* ===== AKSI ===== */
.aksi-btn {
  display: flex;
  flex-direction: column;
  gap: 6px;
  align-items: center;
}

.aksi-btn a {
  width: 80px;
  text-align: center;
}

/* ===== BUTTON ===== */
.btn {
  padding: 6px 0;
  border-radius: 6px;
  color: white;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
}

.acc {
  background: #22c55e;
}

.acc:hover {
  background: #16a34a;
}

.tolak {
  background: #ef4444;
}

.tolak:hover {
  background: #dc2626;
}
</style>

<div class="main-content">
  <div class="container">
    <div class="card">

      <h3 style="margin-bottom:15px;"><i class="fas fa-check-circle" style="color:#6366f1; margin-right:8px;"></i>Persetujuan Peminjaman</h3>

      <table>
        <tr>
          <th>No</th>
          <th>Nama Peminjam</th>
          <th>Nama Alat</th>
          <th>Jumlah</th>
          <th>Tgl Pinjam</th>
          <th>Tgl Kembali</th>
          <th>Aksi</th>
        </tr>

        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
          <td><?= htmlspecialchars($row['nama_alat']) ?></td>
          <td><?= $row['jumlah'] ?></td>
          <td><?= $row['tanggal_pinjam'] ?></td>
          <td><?= $row['tanggal_kembali'] ?></td>
          <td>
            <div class="aksi-btn">
              <a class="btn acc"
                 href="?acc=<?= $row['id_peminjaman'] ?>"
                 onclick="return confirm('Setujui peminjaman ini?')">
                 <i class="fas fa-check"></i> Setujui
              </a>

              <a class="btn tolak"
                 href="?tolak=<?= $row['id_peminjaman'] ?>"
                 onclick="return confirm('Tolak peminjaman ini?')">
                 <i class="fas fa-times"></i> Tolak
              </a>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>

      </table>

    </div>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>