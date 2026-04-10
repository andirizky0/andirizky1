<?php
// ========================================
// KONFIGURASI GLOBAL
// ========================================

// Hitung BASE_URL secara dinamis
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

// Cari posisi folder project di dalam path
$projectFolder = 'ukk_1_AndiRizkyRiyanto';
$pos = strpos($scriptDir, $projectFolder);

if ($pos !== false) {
    $basePath = substr($scriptDir, 0, $pos + strlen($projectFolder)) . '/';
} else {
    $basePath = '/';
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

define('BASE_URL', $protocol . '://' . $host . $basePath);

// Denda per hari keterlambatan (Rp)
define('DENDA_PER_HARI', 5000);

// Denda tambahan berdasarkan kondisi
define('DENDA_RUSAK', 50000);
define('DENDA_HILANG', 200000);
?>
