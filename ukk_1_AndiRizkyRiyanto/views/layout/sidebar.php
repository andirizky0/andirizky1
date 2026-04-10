<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

// ambil role dari session
$role = $_SESSION['role'] ?? 'admin';
?>

<style>

/* RESET */
body {
  margin: 0;
  font-family: 'Inter','Segoe UI', sans-serif;
}

/* SIDEBAR */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 250px;
  height: 100vh;
  background: linear-gradient(to bottom, #0f172a, #1e293b);
  color: white;
  padding-top: 20px;
  overflow-y: auto;
  z-index: 100;
}

/* BRAND */
.sidebar .brand {
  text-align: center;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}

.sidebar .brand h2 {
  margin: 0;
  font-size: 22px;
  background: linear-gradient(90deg, #38bdf8, #6366f1);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
}

.sidebar .brand p {
  font-size: 13px;
  color: #94a3b8;
  margin-top: 4px;
  text-transform: capitalize;
}

.sidebar .brand .brand-icon {
  font-size: 28px;
  color: #38bdf8;
  margin-bottom: 6px;
}

/* MENU */
.sidebar .nav {
  list-style: none;
  padding: 0 12px;
  margin: 0;
}

.sidebar .nav li {
  margin: 4px 0;
}

.sidebar .nav a {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 16px;
  color: #cbd5e1;
  text-decoration: none;
  border-radius: 10px;
  transition: all 0.3s ease;
  font-size: 14px;
  font-weight: 400;
}

.sidebar .nav a i {
  width: 20px;
  text-align: center;
  font-size: 15px;
}

.sidebar .nav a:hover {
  background: linear-gradient(90deg, #38bdf8, #6366f1);
  color: white;
  transform: translateX(4px);
}

/* LOGOUT */
.logout {
  color: #f87171 !important;
}

.logout:hover {
  background: rgba(239,68,68,0.15) !important;
  color: #fca5a5 !important;
  transform: translateX(4px);
}

/* DIVIDER */
.nav-divider {
  border-top: 1px solid rgba(255,255,255,0.08);
  margin: 12px 0;
}

/* ===== INI PALING PENTING ===== */
.main, .main-content {
  margin-left: 250px !important;
  padding: 20px;
  background: #f1f5f9;
  min-height: 100vh;
  flex: 1;
  width: calc(100% - 250px);
  box-sizing: border-box;
}

</style>

<div class="sidebar" id="sidebar">
  <div class="brand">
    <div class="brand-icon"><i class="fas fa-boxes-stacked"></i></div>
    <h2>INVENTORY</h2>
    <p><?= ucfirst($role); ?></p>
  </div>

  <ul class="nav">

    <!-- ADMIN -->
    <?php if ($role === 'admin'): ?>
      <li><a href="<?= BASE_URL ?>views/admin/dashboard_admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/alat/tampil_data_alat.php"><i class="fas fa-tools"></i> Data Alat</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/user/tampil_data.php"><i class="fas fa-users"></i> Data User</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/kategori/tampil_data_kategori.php"><i class="fas fa-folder-open"></i> Kategori</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/peminjaman/tampil_data_peminjaman.php"><i class="fas fa-clipboard-list"></i> Data Peminjaman</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/pengembalian/tampil_data_pengembalian.php"><i class="fas fa-rotate-left"></i> Data Pengembalian</a></li>
      <li><a href="<?= BASE_URL ?>views/admin/aktivitas/tampil_log_aktivitas.php"><i class="fas fa-clock-rotate-left"></i> Log Aktivitas</a></li>
    <?php endif; ?>

    <!-- PETUGAS -->
    <?php if ($role === 'petugas'): ?>
      <li><a href="<?= BASE_URL ?>views/petugas/dashboard_petugas.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/menyetujui.php"><i class="fas fa-check-circle"></i> Menyetujui Pinjaman</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/memantau.php"><i class="fas fa-eye"></i> Memantau</a></li>
      <li><a href="<?= BASE_URL ?>views/petugas/laporan.php"><i class="fas fa-file-alt"></i> Laporan</a></li>
    <?php endif; ?>

    <!-- PEMINJAM -->
    <?php if ($role === 'peminjam'): ?>
      <li><a href="<?= BASE_URL ?>views/peminjam/dashboard_peminjam.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="<?= BASE_URL ?>views/peminjam/mengajukan.php"><i class="fas fa-plus-circle"></i> Lihat Daftar Alat & Ajukan</a></li>
      <li><a href="<?= BASE_URL ?>views/peminjam/kembalikan.php"><i class="fas fa-undo-alt"></i> Mengembalikan Alat</a></li>
    <?php endif; ?>

    <!-- LOGOUT -->
    <?php if ($role !== 'guest'): ?>
      <div class="nav-divider"></div>
      <li><a href="<?= BASE_URL ?>views/index.php" class="logout"><i class="fas fa-right-from-bracket"></i> Logout</a></li>
    <?php endif; ?>

  </ul>
</div>

<script>
function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("active");
}
</script>