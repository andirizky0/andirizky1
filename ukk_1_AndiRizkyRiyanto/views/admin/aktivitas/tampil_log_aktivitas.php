<?php
session_start();

include_once __DIR__ . '/../../../models/m_koneksi.php';
include_once __DIR__ . '/../../../controllers/c_log_aktivitas.php';

$con = new m_koneksi();
$log = new c_log_aktivitas($con);
$data_log = $log->index();
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>

<style>
.wrapper {
  display: flex;
}

.main {
  flex: 1;
  background: #f4f6f9;
  min-height: 100vh;
}

.content {
  padding: 25px;
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

.card {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table thead {
  background: #3b82f6;
  color: #fff;
}

.table th {
  padding: 12px;
  text-align: center;
}

.table td {
  padding: 12px;
  border-bottom: 1px solid #eee;
  vertical-align: middle;
}

.table td:nth-child(3) {
  text-align: left;
}

.table tbody tr:hover {
  background: #f1f5f9;
}

/* FLEX AKTIVITAS */
.aktivitas-box {
  display: flex;
  align-items: center;
  gap: 10px;
}

/* BADGE */
.badge {
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: bold;
  white-space: nowrap;
}

/* WARNA */
.pinjam {
  background: #3b82f6;
  color: #fff;
}

.kembali {
  background: #22c55e;
  color: #fff;
}

/* TEXT */
.aktivitas-text {
  font-size: 13px;
  color: #333;
  line-height: 1.4;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .table th, .table td {
    font-size: 12px;
    padding: 10px;
  }
}
</style>

<div class="wrapper">

<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<div class="main">
<div class="content">

<h2><i class="fas fa-clock-rotate-left" style="color:#6366f1; margin-right:8px;"></i>Log Aktivitas</h2>

<div class="card">
<table class="table">
<thead>
<tr>
<th>ID</th>
<th>Nama</th>
<th>Aktivitas</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>
<?php if ($data_log && mysqli_num_rows($data_log) > 0): ?>
<?php while($row = mysqli_fetch_assoc($data_log)): ?>
<tr>

<td><?= $row['id_log']; ?></td>
<td><?= $row['nama']; ?></td>

<td>
<?php
$aktivitas = strtolower($row['aktivitas']);

/* PINJAM */
if (strpos($aktivitas, 'mengajukan peminjaman') !== false) {
    echo '<div class="aktivitas-box">
            <span class="badge pinjam"><i class="fas fa-inbox"></i> PINJAM</span>
            <span class="aktivitas-text">'.$row['aktivitas'].'</span>
          </div>';
}

/* KEMBALI */
elseif (strpos($aktivitas, 'mengembalikan') !== false) {
    echo '<div class="aktivitas-box">
            <span class="badge kembali"><i class="fas fa-upload"></i> KEMBALI</span>
            <span class="aktivitas-text">'.$row['aktivitas'].'</span>
          </div>';
}

/* DEFAULT */
else {
    echo $row['aktivitas'];
}
?>
</td>

<td><?= $row['tanggal_aktivitas']; ?></td>

</tr>
<?php endwhile; ?>

<?php else: ?>
<tr>
<td colspan="4">Belum ada log aktivitas</td>
</tr>
<?php endif; ?>
</tbody>

</table>
</div>

</div>
</div>

</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>