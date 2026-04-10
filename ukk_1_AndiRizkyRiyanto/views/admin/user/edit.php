<?php
include_once __DIR__ . '/../../../controllers/c_user.php';
if (!defined('BASE_URL')) require_once __DIR__ . '/../../../config.php';
$c_user = new c_user();

// validasi id
if (!isset($_GET['id'])) {
    die("ID user tidak ditemukan!");
}

$id = $_GET['id'];

// ambil data user
$data = $c_user->getById($id);

// proses update
if (isset($_POST['update'])) {
    $c_user->edit($id, $_POST);
    echo "<script>alert('Data berhasil diupdate!'); window.location='" . BASE_URL . "views/admin/user/tampil_data.php';</script>";
    exit;
}
?>

<style>
.main-content {
    min-height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* 🔥 MAIN CONTENT NORMAL */
.main-content {
    padding: 30px;
}

/* 🔥 CARD FORM (DITENGAH) */
.content-wrapper {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 400px;
    margin: 50px auto; /* 🔥 INI KUNCI AGAR KE TENGAH */
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* JUDUL */
.content-wrapper h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* LABEL */
.content-wrapper label {
    font-size: 13px;
    color: #555;
    font-weight: 500;
}

/* INPUT */
.content-wrapper input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 13px;
}

/* FOCUS */
.content-wrapper input:focus {
    border-color: #5a6fd8;
    outline: none;
}

/* BUTTON UPDATE */
button[name="update"] {
    width: 100%;
    background: linear-gradient(135deg, #5a6fd8, #6c7ae0);
    color: white;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

/* HOVER */
button[name="update"]:hover {
    opacity: 0.9;
}

/* BUTTON BATAL */
a {
    display: block;
    text-align: center;
    margin-top: 10px;
    color: #5a6fd8;
    font-weight: 500;
    text-decoration: none;
}
</style>

<div class="main-content">
  <div class="content-wrapper">
    <h2><i class="fas fa-user-edit" style="color:#6366f1; margin-right:8px;"></i>Edit User</h2>

    <form method="POST">
      <div>
        <label>Nama</label><br>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
      </div>

      <div>
        <label>Email</label><br>
        <input type="email" name="email" value="<?= $data['email']; ?>" required>
      </div>

      <div>
        <label>No HP</label><br>
        <input type="text" name="no_tlp" value="<?= $data['no_tlp']; ?>" required>
      </div>

      <div>
        <label>Password</label><br>
        <input type="text" name="password" value="<?= $data['password']; ?>" required>
      </div>

      <div style="margin-top:10px;">
        <button type="submit" name="update">
          <i class="fas fa-save"></i> Update
        </button>

        <a href="<?= BASE_URL ?>views/admin/user/tampil_data.php">
          <i class="fas fa-arrow-left"></i> Batal
        </a>
      </div>
    </form>
  </div>
</div>