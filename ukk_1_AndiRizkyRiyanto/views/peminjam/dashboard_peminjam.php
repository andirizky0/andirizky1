<?php
session_start();
include_once __DIR__ . '/../../models/m_koneksi.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

$db = (new m_koneksi())->koneksi;
$nama = $_SESSION['nama'] ?? '';

$q1 = mysqli_query($db, "SELECT COUNT(*) as total FROM alat WHERE stok > 0");
$alat_tersedia = mysqli_fetch_assoc($q1)['total'] ?? 0;

$q2 = mysqli_query($db, "SELECT COUNT(*) as total FROM peminjaman WHERE nama_peminjam='$nama' AND status='dipinjam'");
$alat_dipinjam = mysqli_fetch_assoc($q2)['total'] ?? 0;

$q3 = mysqli_query($db, "SELECT COUNT(*) as total FROM peminjaman WHERE nama_peminjam='$nama' AND status='menunggu'");
$menunggu = mysqli_fetch_assoc($q3)['total'] ?? 0;

$q4 = mysqli_query($db, "SELECT COUNT(*) as total FROM peminjaman WHERE nama_peminjam='$nama'");
$riwayat = mysqli_fetch_assoc($q4)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Peminjam</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter','Segoe UI', sans-serif; }
body { background: #eef2f7; }

.top-header {
  width: 100%; background: linear-gradient(90deg, #1e293b, #0f172a);
  color: white; padding: 14px; text-align: center; font-weight: 600;
}
.top-header i { margin-right: 8px; color: #38bdf8; }
.wrapper { display: flex; flex: 1; }

.sidebar {
  width: 260px; min-height: 100vh;
  background: linear-gradient(180deg, #0f172a, #1e293b);
  color: #e2e8f0;
}
.brand { text-align: center; padding: 25px 15px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.brand h2 { background: linear-gradient(90deg, #38bdf8, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.brand .brand-icon { font-size: 28px; color: #38bdf8; margin-bottom: 6px; }
.brand p { font-size: 13px; color: #94a3b8; }
.nav { list-style: none; padding: 12px; }
.nav li a {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 16px; text-decoration: none; color: #cbd5e1;
  border-radius: 10px; transition: all 0.3s ease; font-size: 14px; margin-bottom: 4px;
}
.nav li a i { width: 20px; text-align: center; font-size: 15px; }
.nav li a:hover { background: linear-gradient(90deg, #38bdf8, #6366f1); color: #fff; transform: translateX(4px); }
.logout { color: #f87171 !important; }
.logout:hover { background: rgba(239,68,68,0.15) !important; }
.nav-divider { border-top: 1px solid rgba(255,255,255,0.08); margin: 12px 0; }

.main { flex: 1; padding: 25px; }
.header {
  background: white; padding: 18px 20px; border-radius: 12px;
  display: flex; justify-content: space-between; align-items: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}
.header h3 i { color: #6366f1; margin-right: 8px; }

.cards {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px; margin-top: 25px;
}
.card {
  background: white; padding: 24px; border-radius: 14px;
  box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  transition: all 0.3s ease; border-left: 4px solid transparent;
}
.card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
.card:nth-child(1) { border-left-color: #3b82f6; }
.card:nth-child(2) { border-left-color: #22c55e; }
.card:nth-child(3) { border-left-color: #f59e0b; }
.card:nth-child(4) { border-left-color: #8b5cf6; }
.card .card-icon { font-size: 32px; margin-bottom: 10px; }
.card:nth-child(1) .card-icon { color: #3b82f6; }
.card:nth-child(2) .card-icon { color: #22c55e; }
.card:nth-child(3) .card-icon { color: #f59e0b; }
.card:nth-child(4) .card-icon { color: #8b5cf6; }
.card h4 { color: #64748b; font-weight: 500; margin-bottom: 8px; }
.card h1 { font-size: 32px; color: #1e293b; margin-top: 5px; }

.footer { text-align: center; padding: 15px; background: #1e293b; color: #cbd5e1; font-size: 14px; }
.footer i { color: #38bdf8; margin-right: 4px; }
</style>
</head>

<body>

<div class="top-header">
  <i class="fas fa-warehouse"></i> SISTEM INVENTORY & PEMINJAMAN ALAT
</div>

<div class="wrapper">

  <div class="sidebar">
    <div class="brand">
      <div class="brand-icon"><i class="fas fa-boxes-stacked"></i></div>
      <h2>INVENTORY</h2>
      <p>Peminjam</p>
    </div>

    <ul class="nav">
      <li><a href="<?= BASE_URL ?>views/peminjam/dashboard_peminjam.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/peminjam/mengajukan.php"><i class="fas fa-plus-circle"></i> Ajukan</a></li>
      <li><a href="<?= BASE_URL ?>views/peminjam/kembalikan.php"><i class="fas fa-undo-alt"></i> Kembalikan</a></li>
      <div class="nav-divider"></div>
      <li><a href="<?= BASE_URL ?>views/index.php" class="logout"><i class="fas fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <h3><i class="fas fa-home"></i> Dashboard Peminjam</h3>
      <div><i class="fas fa-user" style="color:#6366f1;"></i> Halo, <?= htmlspecialchars($nama) ?></div>
    </div>

    <div class="cards">
      <div class="card">
        <div class="card-icon"><i class="fas fa-boxes-stacked"></i></div>
        <h4>Alat Tersedia</h4>
        <h1><?= $alat_tersedia ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-hand-holding-box"></i></div>
        <h4>Alat Dipinjam</h4>
        <h1><?= $alat_dipinjam ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
        <h4>Menunggu Persetujuan</h4>
        <h1><?= $menunggu ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-history"></i></div>
        <h4>Riwayat Peminjaman</h4>
        <h1><?= $riwayat ?></h1>
      </div>
    </div>
  </div>
</div>

<div class="footer">
  <i class="fas fa-code"></i> © <?= date('Y') ?> Sistem Peminjaman Alat
</div>

</body>
</html>