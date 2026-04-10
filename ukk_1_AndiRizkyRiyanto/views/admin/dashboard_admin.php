<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../../controllers/c_dashboard.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

$dashboard = new c_dashboard();

$totalUser     = $dashboard->countUser();
$totalAlat     = $dashboard->countAlat();
$totalKategori = $dashboard->countKategori();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
  margin: 0; padding: 0; box-sizing: border-box;
  font-family: 'Inter','Segoe UI', sans-serif;
}
body { background: #eef2f7; }

.top-header {
  width: 100%;
  background: linear-gradient(90deg, #1e293b, #0f172a);
  color: white; padding: 14px; text-align: center; font-weight: 600;
}
.top-header i { margin-right: 8px; color: #38bdf8; }

.wrapper { display: flex; }

/* SIDEBAR */
.sidebar {
  width: 260px; min-height: 100vh;
  background: linear-gradient(180deg, #0f172a, #1e293b);
  color: #e2e8f0; position: fixed; left: 0; top: 0;
  transition: 0.3s; z-index: 100;
}
.sidebar.hide { left: -260px; }
.brand { text-align: center; padding: 25px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.brand h2 {
  background: linear-gradient(90deg, #38bdf8, #6366f1);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}
.brand .brand-icon { font-size: 28px; color: #38bdf8; margin-bottom: 6px; }
.nav { list-style: none; padding: 12px; }
.nav li a {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 16px; color: #cbd5e1; text-decoration: none;
  border-radius: 10px; transition: all 0.3s ease; font-size: 14px;
  margin-bottom: 4px;
}
.nav li a i { width: 20px; text-align: center; font-size: 15px; }
.nav li a:hover { background: linear-gradient(90deg, #38bdf8, #6366f1); color: #fff; transform: translateX(4px); }
.logout { color: #f87171 !important; }
.logout:hover { background: rgba(239,68,68,0.15) !important; }
.nav-divider { border-top: 1px solid rgba(255,255,255,0.08); margin: 12px 0; }

/* MAIN */
.main {
  margin-left: 260px; padding: 25px; width: 100%; transition: 0.3s;
}
.main.full { margin-left: 0; }

.header {
  background: white; padding: 18px 20px; border-radius: 12px;
  display: flex; justify-content: space-between; align-items: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}
.header h3 i { color: #6366f1; margin-right: 8px; }

/* CARDS */
.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px; margin-top: 25px;
}

.card {
  background: white; padding: 24px; border-radius: 14px;
  text-align: center;
  box-shadow: 0 6px 16px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  border-left: 4px solid transparent;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}
.card:nth-child(1) { border-left-color: #3b82f6; }
.card:nth-child(2) { border-left-color: #22c55e; }
.card:nth-child(3) { border-left-color: #f59e0b; }

.card .card-icon {
  font-size: 32px; margin-bottom: 10px;
}
.card:nth-child(1) .card-icon { color: #3b82f6; }
.card:nth-child(2) .card-icon { color: #22c55e; }
.card:nth-child(3) .card-icon { color: #f59e0b; }

.card h4 { color: #64748b; font-weight: 500; margin-bottom: 8px; }
.card h2 { font-size: 32px; color: #1e293b; }

@media(max-width:768px){
  .sidebar { left: -260px; }
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

  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="brand">
      <div class="brand-icon"><i class="fas fa-boxes-stacked"></i></div>
      <h2>INVENTORY</h2>
    </div>

    <ul class="nav">
      <li><a href="<?= BASE_URL ?>views/admin/dashboard_admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/alat/tampil_data_alat.php"><i class="fas fa-tools"></i> Data Alat</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/user/tampil_data.php"><i class="fas fa-users"></i> Data User</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/kategori/tampil_data_kategori.php"><i class="fas fa-folder-open"></i> Kategori</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/peminjaman/tampil_data_peminjaman.php"><i class="fas fa-clipboard-list"></i> Data Peminjaman</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/pengembalian/tampil_data_pengembalian.php"><i class="fas fa-rotate-left"></i> Data Pengembalian</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/aktivitas/tampil_log_aktivitas.php"><i class="fas fa-clock-rotate-left"></i> Log Aktivitas</a></li>
      <div class="nav-divider"></div>
      <li><a href="<?= BASE_URL ?>views/index.php" class="logout"><i class="fas fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </div>

  <!-- MAIN -->
  <div class="main" id="main">
    <div class="header">
      <h3><i class="fas fa-chart-pie"></i> Dashboard Admin</h3>
      <div><i class="fas fa-user-shield" style="color:#6366f1;"></i> Admin</div>
    </div>

    <div class="cards">
      <div class="card">
        <div class="card-icon"><i class="fas fa-users"></i></div>
        <h4>Total User</h4>
        <h2><?= $totalUser ?></h2>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-tools"></i></div>
        <h4>Total Alat</h4>
        <h2><?= $totalAlat ?></h2>
      </div>

      <div class="card">
        <div class="card-icon"><i class="fas fa-folder-open"></i></div>
        <h4>Total Kategori</h4>
        <h2><?= $totalKategori ?></h2>
      </div>
    </div>

  </div>
</div>

<script>
function toggleSidebar(){
  let sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("active");
  localStorage.setItem("sidebar", sidebar.classList.contains("active"));
}
window.onload = function(){
  if(localStorage.getItem("sidebar") === "true"){
    document.getElementById("sidebar").classList.add("active");
  }
}
</script>

</body>
</html>