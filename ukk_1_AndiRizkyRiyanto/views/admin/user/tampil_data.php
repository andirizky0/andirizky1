<?php
session_start();
include_once __DIR__ . '/../../../controllers/c_user.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$controller = new c_user();
$data = $controller->index();

// 🔍 FITUR CARI
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
?>

<?php include __DIR__ . '/../../layout/header.php'; ?>
<?php include __DIR__ . '/../../layout/sidebar.php'; ?>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:Arial, sans-serif;
}

.main-content{
  padding:20px;
  background:#f1f5f9;
  min-height:100vh;
}

h2{
  margin-bottom:15px;
  font-size:20px;
  font-weight:600;
}

.card{
  background:#ffffff;
  padding:25px;
  border-radius:14px;
  box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* 🔍 SEARCH */
.search-box{
  margin-bottom:15px;
  display:flex;
  gap:10px;
}

.search-box input{
  padding:8px 12px;
  border-radius:6px;
  border:1px solid #ccc;
  width:250px;
}

.search-box button{
  padding:8px 14px;
  border:none;
  background:#1e3a8a;
  color:white;
  border-radius:6px;
  cursor:pointer;
}

.search-box button:hover{
  background:#172554;
}

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
  font-size:14px;
}

th{
  background:#1e3a8a;
  color:white;
  padding:14px 10px;
  text-align:center;
  font-weight:600;
}

td{
  padding:12px 10px;
  text-align:center;
  border-bottom:1px solid #e5e7eb;
  color:#475569;
}

tr:nth-child(even){
  background:#f8fafc;
}

tr:hover{
  background:#e0f2fe;
  transition:0.2s;
}

.aksi{
  display:flex;
  flex-direction:column;
  gap:6px;
  align-items:center;
}

.edit,
.hapus{
  width:80px;
  padding:6px 0;
  border-radius:6px;
  text-decoration:none;
  font-size:13px;
  font-weight:500;
  color:white;
  text-align:center;
}

.edit{
  background:#3b82f6;
}

.edit:hover{
  background:#2563eb;
}

.hapus{
  background:#ef4444;
}

.hapus:hover{
  background:#dc2626;
}

@media(max-width:768px){
  table{
    font-size:12px;
  }

  .edit,
  .hapus{
    width:70px;
    font-size:12px;
  }
}
</style>

<script>
function confirmHapus(){
    return confirm("Yakin ingin menghapus data ini?");
}
</script>

<div class="main-content">
  <h2><i class="fas fa-users" style="color:#6366f1; margin-right:8px;"></i>Data User</h2>

  <div class="card">

    <!-- 🔍 FORM CARI -->
    <form method="GET" class="search-box">
      <input type="text" name="cari" placeholder="Cari nama user..." value="<?= htmlspecialchars($cari); ?>">
      <button type="submit"><i class="fas fa-search"></i> Cari</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No Telp</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        <?php 
        $no = 1; 
        $found = false; // 🔥 penanda hasil ditemukan
        ?>

        <?php while($row = mysqli_fetch_assoc($data)): ?>

          <?php
          // 🔍 FILTER NAMA
          if ($cari && stripos($row['nama'], $cari) === false) {
              continue;
          }
          $found = true;
          ?>

          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['no_tlp'] ?></td>
            <td><?= $row['role'] ?></td>
            <td class="aksi">
              <a href="<?= BASE_URL ?>views/admin/user/edit.php?id=<?= $row['id_user'] ?>" class="edit"><i class="fas fa-edit"></i> Edit</a>

              <a href="<?= BASE_URL ?>controllers/c_user.php?aksi=hapus&id=<?= $row['id_user'] ?>" 
                 class="hapus"
                 onclick="return confirmHapus()">
                <i class="fas fa-trash"></i> Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>

        <!-- 🔥 JIKA TIDAK ADA HASIL -->
        <?php if (!$found): ?>
          <tr>
            <td colspan="6">Data tidak ditemukan</td>
          </tr>
        <?php endif; ?>

      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>