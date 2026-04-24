<?php
session_start();

// CEK ROLE
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pramuniaga') {
    header('Location: index.php'); 
    exit;
}

// KONEKSI DB
$conn = new mysqli("localhost","root","","warung");
if($conn->connect_error){
    die("Koneksi gagal: ".$conn->connect_error);
}

// ================= DATA =================

// 1. INFORMASI STOK (TOP 10)
$stokBarang = $conn->query("
    SELECT nama, stok 
    FROM barang 
    ORDER BY stok ASC 
    LIMIT 10
");

// 2. STATUS INVENTARIS
$totalBarang = $conn->query("SELECT COUNT(*) as total FROM barang")->fetch_assoc();
$stokHabis = $conn->query("SELECT COUNT(*) as total FROM barang WHERE stok = 0")->fetch_assoc();
$stokAman = $conn->query("SELECT COUNT(*) as total FROM barang WHERE stok > 5")->fetch_assoc();

// 3. BARANG MASUK HARI INI
$hariIni = date("Y-m-d");

$barangMasuk = $conn->query("
    SELECT p.tanggal, b.nama, d.jumlah
    FROM penerimaan p
    JOIN detail_penerimaan d ON p.id = d.penerimaan_id
    JOIN barang b ON d.barang_id = b.id
    WHERE DATE(p.tanggal) = '$hariIni'
");

// 4. STOK MENIPIS
$stokMenipis = $conn->query("
    SELECT nama, stok
    FROM barang
    WHERE stok <= 5
");

// 5. GRAFIK PENJUALAN
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

$namaAkun = $_SESSION['nama'] ?? "Pramuniaga";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Pramuniaga</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    display:flex;
    font-family:Segoe UI;
    background:#FFF8E1;
}

/* SIDEBAR */
.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
    font-weight: bold;
}

.sidebar{
    width:240px;
    background:#FFF8E1;
    padding:20px;
}

.menu a{
    display:block;
    padding:10px;
    text-decoration:none;
    color:#333;
}

.menu a:hover{
    background:#C8E6C9;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

.header{
    font-size:22px;
    margin-bottom:20px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.grid-bottom{
    margin-top:20px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.card{
    background:#A5C4A8;
    border-radius:15px;
    padding:15px;
}

.card h4{
    margin-bottom:10px;
    color:#1A1A1A;
}

.content{
    background:#fff;
    border-radius:10px;
    padding:10px;
    height:160px;
    overflow:auto;
}

.large{
    grid-column:span 2;
}

.profile-img{
    width:50px;
    border-radius:50%;
}

body{
    display:flex;
    font-family:Segoe UI;
    background:#F7F3EE;
}

.sidebar{
    width:240px;
    background:#FFF8E1;
    padding:20px;
}

.menu a{
    display:block;
    padding:10px;
    text-decoration:none;
    color:#333;
}

.menu a:hover{
    background:#C8E6C9;
}

.main{
    flex:1;
    padding:30px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th, .table td{
    padding:10px;
    border-bottom:1px solid #eee;
}

.btn{
    padding:6px 12px;
    background:#2E7D32;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

 * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            display: flex;
            background-color: #FFF8E1;
            color: #1A1A1A;
        }

        /* ===== SIDEBAR ===== */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #FFF8E1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.logo {
    font-size: 22px;
    font-weight: bold;
    color: #1A1A1A;
    margin-bottom: 20px;
}

.profile {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.profile-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #C8E6C9;
    margin-right: 10px;
}

.menu a {
    display: block;
    padding: 12px;
    margin: 5px 0;
    text-decoration: none;
    color: #4A4A4A;
    border-radius: 8px;
}

.menu a:hover {
    background: #C8E6C9;
    color: #1A1A1A;
}

.logout {
    margin-top: 20px;
}
        /* ===== MAIN CONTENT ===== */
        .main {
            flex: 1;
            padding: 30px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* ===== GRID LAYOUT ===== */
        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .card {
            background-color: #C8E6C9;
            border-radius: 15px;
            padding: 15px;
        }

        .card h4 {
            margin-bottom: 10px;
            color: #2E7D32;
        }

        .card-content {
            height: 160px;
            background-color: #ffffff;
            border-radius: 10px;
        }

        /* Bagian bawah */
        .grid-bottom {
            margin-top: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card-large {
            grid-column: span 2;
        }

        /* Responsif */
        @media(max-width: 900px){
            .grid {
                grid-template-columns: 1fr;
            }

            .grid-bottom {
                grid-template-columns: 1fr;
            }

            .card-large {
                grid-column: span 1;
            }
        }

        .profile-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #C8E6C9;
}
</style>
</head>

<body>

<!--SIDEBAR-->
<div class="sidebar">
    <div>
        <div class="logo">Warung Mbak Eni</div>

        <div class="profile">
    <img src="asset/logohijau.png" class="profile-img">
    <div>Resti Putri</div>
</div>

        <div class="menu">
            <a href="pramuniagadashboard.php" class="active">Dashboard</a>
            <a href="pramuniagabarang.php">Barang</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

<div class="header">
    Selamat Datang, <?= $namaAkun ?>
</div>

<!-- ATAS -->
<div class="grid">

    <!-- STOK -->
    <div class="card">
        <h4>Informasi Stok Barang</h4>
        <div class="content">
            <?php while($s = $stokBarang->fetch_assoc()): ?>
                <?= $s['nama'] ?> (<?= $s['stok'] ?>)<br>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- STATUS -->
    <div class="card">
        <h4>Status Inventaris Cepat</h4>
        <div class="content">
            Total Barang: <?= $totalBarang['total'] ?><br>
            Stok Habis: <?= $stokHabis['total'] ?><br>
            Stok Aman: <?= $stokAman['total'] ?>
        </div>
    </div>

</div>

<!-- BAWAH -->
<div class="grid-bottom">

    <!-- BARANG MASUK -->
    <div class="card">
        <h4>Notifikasi Barang Masuk Hari Ini</h4>
        <div class="content">
            <?php if($barangMasuk->num_rows > 0): ?>
                <?php while($b = $barangMasuk->fetch_assoc()): ?>
                    <?= $b['nama'] ?> (<?= $b['jumlah'] ?>)<br>
                <?php endwhile; ?>
            <?php else: ?>
                Tidak ada barang masuk hari ini
            <?php endif; ?>
        </div>
    </div>

    <!-- STOK MENIPIS -->
    <div class="card">
        <h4>Stok Menipis</h4>
        <div class="content">
            <?php while($m = $stokMenipis->fetch_assoc()): ?>
                <?= $m['nama'] ?> (<?= $m['stok'] ?>)<br>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- GRAFIK -->
    <div class="card large">
        <h4>Tren Penjualan</h4>
        <div class="content">
            <canvas id="grafik"></canvas>
        </div>
    </div>

</div>

</div>

<script>
new Chart(document.getElementById('grafik'), {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($total) ?>,
            borderColor: '#2E7D32',
            fill: false
        }]
    }
});
</script>

</body>
</html>