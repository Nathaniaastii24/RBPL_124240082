<?php
session_start();

// ================= CEK LOGIN =================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Kasir') {
    header('Location: index.php');
    exit;
}

// ================= KONEKSI =================
$conn = new mysqli("localhost","root","","warung");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$namaAkun = $_SESSION['nama'] ?? "Kasir";
$today = date("Y-m-d");

// ================= DATA =================

// STATUS KASIR
$statusKasir = $conn->query("
    SELECT COUNT(*) as jumlah 
    FROM penjualan 
    WHERE DATE(tanggal) = '$today'
")->fetch_assoc();
$status = ($statusKasir['jumlah'] > 0) ? "Aktif" : "Belum Buka";

// TOTAL TRANSAKSI SEMUA
$totalTransaksi = $conn->query("
    SELECT COUNT(*) as total 
    FROM penjualan
")->fetch_assoc();

// PRODUK TERLARIS
$laris = $conn->query("
    SELECT b.nama, SUM(d.jumlah) as terjual
    FROM detail_penjualan d
    JOIN barang b ON d.barang_id = b.id
    GROUP BY b.id
    ORDER BY terjual DESC
    LIMIT 1
")->fetch_assoc();

// TOTAL PENJUALAN HARI INI
$totalHariIni = $conn->query("
    SELECT IFNULL(SUM(total),0) as total 
    FROM penjualan
    WHERE DATE(tanggal) = '$today'
")->fetch_assoc();

// JUMLAH TRANSAKSI HARI INI
$transaksiHariIni = $conn->query("
    SELECT COUNT(*) as jumlah 
    FROM penjualan
    WHERE DATE(tanggal) = '$today'
")->fetch_assoc();

// METODE PEMBAYARAN
$metode = $conn->query("
    SELECT metode, COUNT(*) as jumlah
    FROM penjualan
    WHERE DATE(tanggal) = '$today'
    GROUP BY metode
");

// RIWAYAT
$riwayat = $conn->query("
    SELECT * FROM penjualan
    ORDER BY tanggal DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Kasir</title>

<style>
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI;
}

body {
    display:flex;
    background:#F7F3EE;
}

/* SIDEBAR */
.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
    font-weight: bold;
}

.sidebar {
    width:240px;
    height:100vh;
    background:#FFF8E1;
    padding:20px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo {
    font-size:22px;
    font-weight:bold;
    margin-bottom:20px;
}

.profile {
    display:flex;
    align-items:center;
    margin-bottom:30px;
}

.profile img {
    width:55px;
    height:55px;
    border-radius:50%;
    margin-right:10px;
}

.menu a {
    display:block;
    padding:12px;
    margin:5px 0;
    text-decoration:none;
    color:#4A4A4A;
    border-radius:8px;
}

.menu a:hover {
    background:#C8E6C9;
}

/* MAIN */
.main {
    flex:1;
    padding:40px;
}

.top-header {
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
}

.welcome {
    font-size:26px;
    font-weight:600;
}

/* CARD */
.card-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.card {
    background:white;
    border-radius:16px;
    padding:20px;
    height:110px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.card-title {
    color:#4A4A4A;
}

.card-value {
    font-size:20px;
    font-weight:bold;
    color:#2E7D32;
}

/* SECTION */
.section-title {
    font-size:22px;
    font-weight:600;
    margin-bottom:15px;
}

/* HISTORY */
.history-box {
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.history-content {
    margin-top:10px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <div class="logo">Warung Mbak Eni</div>

        <div class="profile">
            <img src="asset/logohijau.png">
            <div><?= $namaAkun ?></div>
        </div>

        <div class="menu">
            <a href="kasirdashboard.php" class="active">Dashboard</a>
            <a href="kasirpenjualan.php">Penjualan</a>
            <a href="kasirtutup.php">Tutup Kasir</a>
        </div>
    </div>

    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="top-header">
    <div class="welcome">Selamat Datang, <?= $namaAkun ?></div>
    <div>🔔 ⋮</div>
</div>

<!-- CARD ATAS -->
<div class="card-grid">

    <div class="card">
        <div class="card-title">Status Kasir</div>
        <div class="card-value"><?= $status ?></div>
    </div>

    <div class="card">
        <div class="card-title">Total Transaksi</div>
        <div class="card-value"><?= $totalTransaksi['total'] ?></div>
    </div>

    <div class="card">
        <div class="card-title">Produk Terlaris</div>
        <div class="card-value"><?= $laris['nama'] ?? '-' ?></div>
    </div>

</div>

<!-- RINGKASAN -->
<div class="section-title">Ringkasan Hari Ini</div>

<div class="card-grid">

    <div class="card">
        <div class="card-title">Total Penjualan</div>
        <div class="card-value">Rp <?= number_format($totalHariIni['total']) ?></div>
    </div>

    <div class="card">
        <div class="card-title">Jumlah Transaksi</div>
        <div class="card-value"><?= $transaksiHariIni['jumlah'] ?></div>
    </div>

    <div class="card">
        <div class="card-title">Metode Pembayaran</div>
        <div style="font-size:14px;">
            <?php while($m = $metode->fetch_assoc()): ?>
                <?= $m['metode'] ?> (<?= $m['jumlah'] ?>)<br>
            <?php endwhile; ?>
        </div>
    </div>

</div>

<!-- RIWAYAT -->
<div class="history-box">
    <b>Riwayat Transaksi</b>

    <div class="history-content">
        <?php while($r = $riwayat->fetch_assoc()): ?>
            <div>
                <?= $r['tanggal'] ?> - Rp <?= number_format($r['total']) ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</div>

</body>
</html>