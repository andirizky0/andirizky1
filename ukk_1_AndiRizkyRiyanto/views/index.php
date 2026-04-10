<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            display: flex;
            justify-content: center;
            align-items: center;

            /* Gradient animasi */
            background: linear-gradient(-45deg, #1f4037, #99f2c8, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            position: relative;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Overlay tipis untuk tekstur */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0; left: 0;
            background: url('https://www.transparenttextures.com/patterns/diamond-upholstery.png') repeat;
            opacity: 0.05;
            z-index: 0;
        }

        .login-container {
            background: rgba(255,255,255,0.95);
            width: 370px;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            text-align: center;
            animation: fadeIn 0.8s ease;
            position: relative;
            z-index: 1; /* agar berada di atas overlay */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LOGO GUNUNG */
        .logo {
            font-size: 40px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 0;
            font-size: 26px;
            color: #2c5364;
        }

        p {
            margin: 8px 0 20px;
            color: #666;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #2c5364;
            box-shadow: 0 0 0 3px rgba(44,83,100,0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #2c5364, #203a43);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .link {
            margin-top: 15px;
        }

        .link a {
            text-decoration: none;
            color: #2c5364;
            font-size: 14px;
            font-weight: 600;
        }

        .error {
            background: #ffe5e5;
            color: #d8000c;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../config.php';
}
?>

<div class="login-container">

    <!-- LOGO -->
    <div class="logo"><i class="fas fa-mountain" style="color:#2c5364;"></i></div>

    <h2>Login</h2>
    <p>Sistem Peminjaman Alat Gunung</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">Email atau password salah!</div>
    <?php endif; ?>

    <!-- FORM LOGIN -->
    <form method="POST" action="<?= BASE_URL ?>controllers/c_reglog.php?aksi=login">
        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
    </form>

    <div class="link">
        <a href="<?= BASE_URL ?>views/register.php"><i class="fas fa-user-plus"></i> Belum punya akun? Register</a>
    </div>

</div>

</body>
</html>