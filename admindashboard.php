<?php
session_start();

// CEK LOGIN + ROLE
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: index.php');
    exit;
}

// NAMA AKUN
$namaAkun = $_SESSION['nama'] ?? "Admin";

// KONEKSI DB
$conn = new mysqli("localhost","root","","warung");

// ================== DATA ==================

// transaksi hari ini
$transaksi = $conn->query("
    SELECT COUNT(*) as jumlah
    FROM penjualan
    WHERE DATE(tanggal) = CURDATE()
")->fetch_assoc();

// stok menipis
$stokMenipis = $conn->query("
    SELECT * FROM barang
    WHERE stok < 5
");

// ringkasan barang
$summary = $conn->query("
    SELECT 
        COUNT(*) as total_barang,
        SUM(stok) as total_stok
    FROM barang
")->fetch_assoc();

// grafik penjualan
$grafik = $conn->query("
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM penjualan
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

$tanggal = [];
$total = [];

while($g = $grafik->fetch_assoc()){
    $tanggal[] = $g['tgl'];
    $total[] = $g['total'];
}

// daftar barang
$barangList = $conn->query("SELECT nama, stok FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Warung Mbak Eni</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
* {margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI;}
body {background:#F7F3EE;display:flex;}

/* SIDEBAR */
.sidebar {
    width:240px;
    height:100vh;
    background:#FFF8E1;
    padding:20px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
    font-weight: bold;
}

.logo {font-size:22px;font-weight:bold;margin-bottom:20px;}

.profile {display:flex;align-items:center;margin-bottom:25px;}
.profile-img {
    width:55px;height:55px;border-radius:50%;
    border:2px solid #C8E6C9;
}

.menu a {
    display:block;
    padding:12px;
    margin:5px 0;
    text-decoration:none;
    color:#4A4A4A;
    border-radius:8px;
}
.menu a:hover {background:#C8E6C9;color:#1A1A1A;}

.main {flex:1;padding:25px;}

.topbar {
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

.grid {
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.card {
    background:white;
    border-radius:14px;
    padding:15px;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
}

.grid-bottom {
    margin-top:20px;
    display:grid;
    grid-template-columns:1fr 2fr;
    gap:20px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <div class="logo">Warung Mbak Eni</div>

        <div class="profile">
            <img src="asset/logohijau.png" class="profile-img">
            <div style="margin-left:10px;">Vina Delvina</div>
        </div>

        <div class="menu">
    <a href="admindashboard.php" class="active">Dashboard</a>
    <a href="adminkelolabarang.php">Kelola Barang</a>
    <a href="adminpenerimaan.php">Input Penerimaan</a>
    <a href="adminpo.php">Purchase Order</a>
    <a href="adminlaporan.php">Laporan</a>
</div>
    </div>

    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">
    <h2>Selamat Datang, <?= $namaAkun ?></h2>
</div>

<div class="grid">

    <!-- GRAFIK -->
    <div class="card">
        <h3>Grafik Penjualan</h3>
        <canvas id="grafik"></canvas>
    </div>

    <!-- TRANSAKSI -->
    <div class="card">
        <h3>Transaksi Hari Ini</h3>
        <h1><?= $transaksi['jumlah'] ?></h1>
    </div>

</div>

<div class="grid-bottom">

    <!-- STOK MENIPIS -->
    <div class="card">
        <h3>Stok Menipis</h3>

        <?php if($stokMenipis->num_rows > 0): ?>
            <?php while($s = $stokMenipis->fetch_assoc()): ?>
                <div><?= $s['nama'] ?> (<?= $s['stok'] ?>)</div>
            <?php endwhile; ?>
        <?php else: ?>
            <div>Semua aman</div>
        <?php endif; ?>
    </div>

    <!-- RINGKASAN + LIST -->
    <div class="card">
        <h3>Ringkasan Stok</h3>

        Total Barang: <b><?= $summary['total_barang'] ?? 0 ?></b><br>
        Total Stok: <b><?= $summary['total_stok'] ?? 0 ?></b>

        <hr style="margin:10px 0;">

        <h4>Daftar Barang</h4>

        <?php while($b = $barangList->fetch_assoc()): ?>
            <div><?= $b['nama'] ?> - <?= $b['stok'] ?></div>
        <?php endwhile; ?>

    </div>

</div>

</div>

<!-- SCRIPT GRAFIK -->
<script>
const ctx = document.getElementById('grafik');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($total) ?>,
            borderColor: '#2E7D32',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>