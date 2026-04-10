<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config.php';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: #fff;
            width: 360px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            text-align: center;
        }

        .box h2 {
            margin-bottom: 10px;
        }

        .box input, .box select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .box button {
            width: 100%;
            padding: 12px;
            background: #43cea2;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        .box button:hover {
            background: #2fa37a;
        }

        .link {
            margin-top: 15px;
        }

        .link a {
            text-decoration: none;
            color: #185a9d;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="box">
    <h2><i class="fas fa-user-plus" style="color:#185a9d;"></i> Register</h2>

    <form method="POST" action="<?= BASE_URL ?>controllers/c_reglog.php?aksi=register">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="no_tlp" placeholder="no telpon" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
  <option value="admin">Admin</option>
  <option value="petugas">Petugas</option>
  <option value="peminjam">peminjam</option>
</select>

        <button type="submit"><i class="fas fa-check-circle"></i> Register</button>
    </form>

    <div class="link">
        <a href="<?= BASE_URL ?>views/index.php"><i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login</a>
    </div>
</div>

</body>
</html>