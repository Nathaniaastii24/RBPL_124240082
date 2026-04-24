<?php
session_start();

$conn = new mysqli("localhost", "root", "", "warung");

// ================== FILTER TANGGAL ==================
$awal  = $_GET['awal'] ?? date('Y-m-01');
$akhir = $_GET['akhir'] ?? date('Y-m-d');

// ================== LAPORAN LABA ==================
$laba = $conn->query("
    SELECT 
        SUM(total) as total_penjualan,
        COUNT(*) as jumlah_transaksi
    FROM penjualan
    WHERE DATE(tanggal) BETWEEN '$awal' AND '$akhir'
")->fetch_assoc();

// ================== LAPORAN STOK ==================
$stok = $conn->query("SELECT * FROM barang");

?>

<!DOCTYPE html>
<html>
<head>
<title>Laporan</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Segoe UI, sans-serif;
}

body {
    background: #F7F3EE;
    display: flex;
}

/* ===== SIDEBAR ===== */
.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
    font-weight: bold;
}

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
    padding: 25px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.welcome {
    font-size: 22px;
    font-weight: 600;
    color: #1A1A1A;
}

.search {
    width: 300px;
    padding: 10px;
    border-radius: 20px;
    border: none;
    background: #FFF8E1;
}

/* ===== CARDS ===== */
.grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.card {
    background: white;
    border-radius: 14px;
    padding: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.card-title {
    font-weight: 600;
    margin-bottom: 10px;
    color: #1A1A1A;
}

.placeholder {
    width: 100%;
    height: 180px;
    border-radius: 10px;
    background: #FFF8E1;
    border: 2px dashed #C8E6C9;
}

.grid-bottom {
    margin-top: 20px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 20px;
}

.profile-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #C8E6C9;
}

body{
    display:flex;
    font-family:Segoe UI;
    background:#F7F3EE;
}

/* SIDEBAR */
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

.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
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
    padding:8px 15px;
    background:#2E7D32;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.filter{
    margin-bottom:15px;
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
    <div>Vina Delvina</div>
</div>

        <div class="menu">
            <a href="admindashboard.php">Dashboard</a>
            <a href="adminkelolabarang.php">Kelola Barang</a>
            <a href="adminpenerimaan.php">Input Penerimaan</a>
            <a href="adminpo.php">Purchase Order</a>
            <a href="adminlaporan.php" class="active">Laporan</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

<h2>Laporan</h2>

<!-- ================== FILTER ================== -->
<div class="card">
    <form method="GET" class="filter">
        Dari: <input type="date" name="awal" value="<?= $awal ?>">
        Sampai: <input type="date" name="akhir" value="<?= $akhir ?>">
        <button class="btn">Filter</button>
    </form>
</div>

<!-- ================== LAPORAN LABA ================== -->
<div class="card">
    <h3>Laporan Penjualan</h3>

    <p>Total Transaksi: <b><?= $laba['jumlah_transaksi'] ?? 0 ?></b></p>
    <p>Total Penjualan: <b>Rp <?= number_format($laba['total_penjualan'] ?? 0) ?></b></p>

    <hr>

    <h4>Detail Transaksi</h4>

    <table class="table">
        <tr>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Metode</th>
        </tr>

        <?php
        $detail = $conn->query("
            SELECT * FROM penjualan
            WHERE DATE(tanggal) BETWEEN '$awal' AND '$akhir'
            ORDER BY tanggal DESC
        ");

        while($d = $detail->fetch_assoc()):
        ?>
        <tr>
            <td><?= $d['tanggal'] ?></td>
            <td>Rp <?= number_format($d['total']) ?></td>
            <td><?= $d['metode'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- ================== LAPORAN STOK ================== -->
<div class="card">
    <h3>Laporan Stok Barang</h3>

    <table class="table">
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>

        <?php while($s = $stok->fetch_assoc()): ?>
        <tr>
            <td><?= $s['nama'] ?></td>
            <td>Rp <?= number_format($s['harga']) ?></td>
            <td><?= $s['stok'] ?></td>
            <td>
                <?php if($s['stok'] < 5): ?>
                    <span style="color:red;">Stok Menipis</span>
                <?php else: ?>
                    <span style="color:green;">Aman</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</div>

</body>
</html>