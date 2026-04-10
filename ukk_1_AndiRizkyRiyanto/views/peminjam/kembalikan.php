<?php
session_start();
include_once __DIR__ . '/../../controllers/c_kembalikan.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../config.php';

$c = new c_kembalikan();
$c->proses();

$nama = $_SESSION['nama'] ?? '';
$data = $c->index($nama);
?>

<?php include __DIR__ . '/../layout/header.php'; ?>
<?php include __DIR__ . '/../layout/sidebar.php'; ?>

<style>
.container { padding:25px; }

.card {
  background:white;
  padding:20px;
  border-radius:12px;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
}

table {
  width:100%;
  border-collapse:collapse;
}

th, td {
  padding:12px;
  border-bottom:1px solid #e5e7eb;
  text-align:center;
}

th {
  background:#1e40af;
  color:white;
}

.badge {
  padding:6px 12px;
  border-radius:6px;
  color:white;
  font-size:12px;
}

.menunggu { background:#f59e0b; }
.dipinjam { background:#2563eb; }
.kembali { background:#16a34a; }
.terlambat { background:#ef4444; }

.btn {
  padding:6px 12px;
  border-radius:6px;
  text-decoration:none;
  color:white;
  cursor:pointer;
  border:none;
}

.btn-kembali { background:#16a34a; }

/* MODAL STYLES */
.modal {
  display: none; 
  position: fixed; 
  z-index: 1000; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgba(0,0,0,0.5); 
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto; 
  padding: 25px;
  border: 1px solid #888;
  width: 400px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
}

.info-denda {
  margin: 15px 0;
  padding: 10px;
  background: #fee2e2;
  border-left: 4px solid #ef4444;
  font-size: 14px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group select {
    width: 100%;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
</style>

<div class="main-content">
  <div class="container">
    <div class="card">

<h3><i class="fas fa-undo-alt" style="color:#6366f1; margin-right:8px;"></i>Data Peminjaman Saya</h3>

<?php if (isset($_GET['success'])): ?>
  <p style="color:green; padding: 10px; background: #dcfce7; border-radius: 5px; margin-bottom: 15px;"><i class="fas fa-check-circle"></i> Aksi berhasil dilakukan!</p>
<?php endif; ?>

<table>
<tr>
  <th>No</th>
  <th>Nama Alat</th>
  <th>Jumlah</th>
  <th>Jatuh Tempo</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>

<?php if ($data && mysqli_num_rows($data) > 0): ?>
<?php $no=1; while($row = mysqli_fetch_assoc($data)): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($row['nama_alat']) ?></td>
  <td><?= $row['jumlah'] ?></td>
  <td><?= $row['tanggal_kembali'] ?></td>

  <td>
    <?php if ($row['status'] == 'menunggu'): ?>
      <span class="badge menunggu">Menunggu</span>
    <?php elseif ($row['status'] == 'dipinjam'): ?>
      <?php if($row['hari_terlambat'] > 0): ?>
          <span class="badge terlambat">Terlambat <?= $row['hari_terlambat'] ?> Hari</span>
      <?php else: ?>
          <span class="badge dipinjam">Dipinjam</span>
      <?php endif; ?>
    <?php else: ?>
      <span class="badge kembali">Dikembalikan</span>
    <?php endif; ?>
  </td>

  <td>
    <?php if ($row['status'] == 'dipinjam'): ?>
      <button class="btn btn-kembali" 
              onclick="bukaModal(<?= $row['id_peminjaman'] ?>, '<?= addslashes($row['nama_alat']) ?>', <?= (int)$row['estimasi_denda'] ?>)">
         <i class="fas fa-undo-alt"></i> Kembalikan
      </button>
    <?php else: ?>
      -
    <?php endif; ?>
  </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
  <td colspan="6">Tidak ada data</td>
</tr>
<?php endif; ?>

</table>

    </div>
  </div>
</div>

<!-- MODAL KEMBALIKAN -->
<div id="modalKembalikan" class="modal">
  <div class="modal-content">
    <span class="close" onclick="tutupModal()">&times;</span>
    <h3 style="margin-top:0"><i class="fas fa-undo-alt" style="color:#6366f1; margin-right:6px;"></i>Kembalikan Alat</h3>
    <p>Nama Alat: <b id="textNamaAlat"></b></p>
    
    <div id="infoDenda" class="info-denda" style="display:none;">
        <p><i class="fas fa-exclamation-triangle" style="color:#ef4444;"></i> Anda terlambat! Denda saat ini: <b>Rp <span id="textDenda"></span></b></p>
        <small>*Belum termasuk denda jika kondisi barang rusak/hilang</small>
    </div>

    <form method="GET">
        <input type="hidden" name="kembalikan" id="inputId" value="">
        
        <div class="form-group">
            <label>Kondisi Barang Saat Dikembalikan:</label>
            <select name="kondisi" required>
                <option value="Baik">Baik (Normal)</option>
                <option value="Rusak">Rusak (+ <?= number_format(DENDA_RUSAK,0,',','.') ?>)</option>
                <option value="Hilang">Hilang (+ <?= number_format(DENDA_HILANG,0,',','.') ?>)</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-kembali" style="width: 100%; margin-top: 10px;"><i class="fas fa-check"></i> Konfirmasi Pengembalian</button>
    </form>
  </div>
</div>

<script>
function bukaModal(id, nama, denda) {
    document.getElementById('inputId').value = id;
    document.getElementById('textNamaAlat').innerText = nama;
    
    if (denda > 0) {
        document.getElementById('infoDenda').style.display = 'block';
        // Format rupiah
        document.getElementById('textDenda').innerText = new Intl.NumberFormat('id-ID').format(denda);
    } else {
        document.getElementById('infoDenda').style.display = 'none';
    }
    
    document.getElementById('modalKembalikan').style.display = 'block';
}

function tutupModal() {
    document.getElementById('modalKembalikan').style.display = 'none';
}

// Tutup modal jika klik di luar modal
window.onclick = function(event) {
    var modal = document.getElementById('modalKembalikan');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>