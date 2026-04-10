<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Inventory</title>

<!-- FONT AWESOME 6 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- GOOGLE FONTS - Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Inter','Segoe UI',sans-serif;
}

body{
  background:#eef2f7;
}

/* HEADER ATAS */
.top-header{
  width:100%;
  background:linear-gradient(90deg,#1e293b,#0f172a);
  color:#fff;
  padding:14px;
  text-align:center;
  font-weight:600;
  font-size:15px;
  letter-spacing:0.5px;
  position:relative;
  z-index:10;
}

.top-header i {
  margin-right:8px;
  color:#38bdf8;
}

/* WRAPPER */
.wrapper{
  display:flex;
  min-height:100vh;
}

/* SIDEBAR */
.sidebar{
  width:260px;
  background:linear-gradient(180deg,#0f172a,#1e293b);
  color:#e2e8f0;
}

.brand{
  text-align:center;
  padding:25px;
  border-bottom:1px solid rgba(255,255,255,0.1);
}

.brand h2{
  background:linear-gradient(90deg,#38bdf8,#6366f1);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.nav{
  list-style:none;
  padding:20px 12px;
}

.nav li a{
  display:flex;
  align-items:center;
  gap:12px;
  padding:12px 16px;
  margin-bottom:6px;
  text-decoration:none;
  color:#cbd5e1;
  border-radius:10px;
  transition:all 0.3s ease;
  font-size:14px;
}

.nav li a i {
  width:20px;
  text-align:center;
  font-size:15px;
}

.nav li a:hover,
.nav li a.active{
  background:linear-gradient(90deg,#38bdf8,#6366f1);
  color:#fff;
  transform:translateX(4px);
}

/* MAIN */
.main{
  flex:1;
  padding:40px;
}

/* CONTENT */
.content{
  max-width:100%;
  width:100%;
}

.page-title{
  text-align:left;
  font-size:22px;
  font-weight:bold;
  margin-bottom:25px;
  color:#1e293b;
}

/* CARD */
.card{
  background:#fff;
  padding:25px;
  border-radius:14px;
  box-shadow:0 8px 20px rgba(0,0,0,0.06);
}

/* FORM */
.form-inline{
  display:flex;
  gap:10px;
  margin-bottom:20px;
}

.form-inline input{
  flex:1;
  padding:10px 14px;
  border-radius:8px;
  border:1px solid #cbd5e1;
}

.form-inline button{
  padding:10px 18px;
  border-radius:8px;
  border:none;
  background:#22c55e;
  color:#fff;
  cursor:pointer;
}

/* TABLE */
.table{
  width:100%;
  border-collapse:collapse;
}

.table th{
  background:#6366f1;
  color:#fff;
  padding:12px;
}

.table td{
  padding:12px;
  text-align:center;
  border-bottom:1px solid #e5e7eb;
}

.table tr:hover{
  background:#f1f5f9;
}

/* ================= FOOTER ================= */
.footer {
  text-align: center;
  padding: 15px 0;
  background: #1e293b;
  color: #cbd5e1;
  font-size: 14px;
  border-top: 1px solid rgba(255,255,255,0.1);
  position: relative;
  width: 100%;
  margin-top: 20px;
}

.footer i {
  color:#38bdf8;
  margin-right:4px;
}

/* BUTTON */
.btn{
  padding:6px 12px;
  border-radius:6px;
  font-size:12px;
  text-decoration:none;
  color:#fff;
  transition:all 0.2s ease;
  display:inline-flex;
  align-items:center;
  gap:5px;
}

.btn:hover {
  transform:translateY(-1px);
  box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

.btn-edit{background:#3b82f6;}
.btn-hapus{background:#ef4444;}
.btn-edit:hover{background:#2563eb;}
.btn-hapus:hover{background:#dc2626;}
</style>
</head>

<body>

<div class="top-header">
  <i class="fas fa-warehouse"></i> Sistem Inventory & Peminjaman Alat
</div>

<div class="wrapper">