<?php
session_start();
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: " . BASE_URL . "views/index.php");
    exit;
}

include_once __DIR__ . '/../../controllers/c_petugas.php';
$ctrl = new c_petugas();
$data = $ctrl->dashboard();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Petugas</title>
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
.wrapper { display: flex; }

.sidebar {
  width: 260px; min-height: 100vh;
  background: linear-gradient(180deg, #0f172a, #1e293b);
  color: #e2e8f0; position: fixed; left: 0; top: 0; z-index: 100;
}
.brand { text-align: center; padding: 25px 15px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.brand h2 { background: linear-gradient(90deg, #38bdf8, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.brand .brand-icon { font-size: 28px; color: #38bdf8; margin-bottom: 6px; }
.brand p { font-size: 13px; color: #94a3b8; }
.nav { list-style: none; padding: 12px; }
.nav li { margin-bottom: 4px; }
.nav li a {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 16px; border-radius: 10px; text-decoration: none;
  color: #cbd5e1; transition: all 0.3s ease; font-size: 14px;
}
.nav li a i { width: 20px; text-align: center; font-size: 15px; }
.nav li a:hover { background: linear-gradient(90deg, #38bdf8, #6366f1); color: #fff; transform: translateX(4px); }
.logout { color: #f87171 !important; }
.nav-divider { border-top: 1px solid rgba(255,255,255,0.08); margin: 12px 0; }

.main { margin-left: 260px; padding: 25px; width: 100%; }
.header {
  background: white; padding: 18px 20px; border-radius: 12px;
  display: flex; justify-content: space-between; align-items: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}
.header h3 i { color: #6366f1; margin-right: 8px; }

.cards {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px; margin-top: 25px;
}
.card {
  background: white; padding: 24px; border-radius: 14px; text-align: center;
  box-shadow: 0 6px 16px rgba(0,0,0,0.05); transition: all 0.3s ease;
  border-left: 4px solid transparent;
}
.card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
.card:nth-child(1) { border-left-color: #f59e0b; }
.card:nth-child(2) { border-left-color: #3b82f6; }
.card:nth-child(3) { border-left-color: #22c55e; }
.card:nth-child(4) { border-left-color: #8b5cf6; }
.card .card-icon { font-size: 32px; margin-bottom: 10px; }
.card:nth-child(1) .card-icon { color: #f59e0b; }
.card:nth-child(2) .card-icon { color: #3b82f6; }
.card:nth-child(3) .card-icon { color: #22c55e; }
.card:nth-child(4) .card-icon { color: #8b5cf6; }
.card h4 { color: #64748b; font-weight: 500; margin-bottom: 8px; }
.card h1 { margin-top: 5px; font-size: 28px; color: #1e293b; }

@media(max-width:768px){
  .sidebar { position: fixed; left: -260px; }
  .sidebar.active { left: 0; }
  .main { margin-left: 0; }
}
</style>
</head>

<body>

<div class="top-header">
  <i class="fas fa-warehouse"></i> SISTEM INVENTORY & PEMINJAMAN ALAT
</div>

<div class="wrapper">

  <div class="sidebar" id="sidebar">
    <div class="brand">
      <div class="brand-icon"><i class="fas fa-boxes-stacked"></i></div>
      <h2>INVENTORY</h2>
      <p>Petugas</p>
    </div>

    <ul class="nav">
      <li><a href="<?= BASE_URL ?>views/petugas/dashboard_petugas.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/menyetujui.php"><i class="fas fa-check-circle"></i> Menyetujui Pinjaman</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/memantau.php"><i class="fas fa-eye"></i> Memantau Pengembalian</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/laporan.php"><i class="fas fa-file-alt"></i> Laporan</a></li>
      <div class="nav-divider"></div>
      <li><a href="<?= BASE_URL ?>views/index.php" class="logout"><i class="fas fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <h3><i class="fas fa-chart-pie"></i> Dashboard Petugas</h3>
      <div><i class="fas fa-user-tie" style="color:#6366f1;"></i> Halo, Petugas</div>
    </div>

    <div class="cards">
      <div class="card">
        <div class="card-icon"><i class="fas fa-inbox"></i></div>
        <h4>Permintaan Masuk</h4>
        <h1><?= $data['menunggu'] ?? 0; ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-spinner"></i></div>
        <h4>Diproses</h4>
        <h1><?= $data['disetujui'] ?? 0; ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-rotate-left"></i></div>
        <h4>Pengembalian</h4>
        <h1><?= $data['pengembalian'] ?? 0; ?></h1>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-file-lines"></i></div>
        <h4>Total Laporan</h4>
        <h1><?= $data['log'] ?? 0; ?></h1>
      </div>
    </div>

  </div>
</div>

<script>
function toggleSidebar(){
  document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>