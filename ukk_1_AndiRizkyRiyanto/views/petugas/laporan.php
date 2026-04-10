<?php
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../controllers/c_laporan.php';

$ctrl = new c_laporan();
$result = $ctrl->index();

$data = $result['data'];
$tanggal = $result['tanggal'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan Peminjaman</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
  font-family:sans-serif;
  margin:0;
  background:#f1f5f9;
}

.container {
  padding:20px;
}

h2, p {
  text-align:center;
}

.table-box {
  background:white;
  padding:20px;
  border-radius:10px;
}

/* TABEL */
table {
  width:100%;
  border-collapse:collapse;
}

th, td {
  border:1px solid black;
  padding:10px;
  text-align:center;
}

th {
  background:#e2e8f0;
}

/* TOMBOL */
.btn-wrapper {
  margin-top:15px;
  text-align:left;
}

.btn {
  padding:12px 20px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-size:14px;
  margin-right:10px;
}

.pdf {
  background:#ef4444;
  color:white;
}

.jpg {
  background:#22c55e;
  color:white;
}

.back-btn {
  display: inline-block;
  padding: 12px 20px;
  background: #64748b;
  color: white;
  text-decoration: none;
  border-radius: 8px;
  margin-right: 10px;
}

/* SEMBUNYIKAN TOMBOL SAAT PRINT */
@media print {
    .btn-wrapper, .back-btn {
        display: none !important;
    }
}
</style>
</head>

<body>

<div class="container">

<div id="areaCetak" class="table-box">

<h2><i class="fas fa-file-alt" style="color:#6366f1;"></i> LAPORAN PEMINJAMAN ALAT</h2>

<p>Tanggal Cetak: <?= $tanggal ?></p>

<table>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Alat</th>
  <th>Tanggal Pinjam</th>
  <th>Tanggal Kembali</th>
  <th>Status</th>
</tr>

<?php $no=1; foreach($data as $row): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
  <td><?= htmlspecialchars($row['nama_alat']) ?></td>
  <td><?= $row['tanggal_pinjam'] ?></td>
  <td><?= $row['tanggal_kembali'] ?: '-' ?></td>
  <td><?= $row['status'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</div>

<!-- 🔥 TOMBOL DI KIRI -->
<div class="btn-wrapper">
  <button class="btn pdf" onclick="cetakPDF()"><i class="fas fa-file-pdf"></i> Simpan PDF</button>
  <button class="btn jpg" onclick="cetakJPG()"><i class="fas fa-image"></i> Simpan JPG</button>
  <a href="<?= BASE_URL ?>views/petugas/dashboard_petugas.php" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

</div>

<!-- 🔥 LIBRARY JPG -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
function cetakPDF() {
    window.print(); // pakai print → pilih save as PDF
}

function cetakJPG() {
    let area = document.getElementById("areaCetak");

    html2canvas(area).then(canvas => {
        let link = document.createElement("a");
        link.download = "laporan_peminjaman.jpg";
        link.href = canvas.toDataURL("image/jpeg");
        link.click();
    });
}
</script>

</body>
</html>