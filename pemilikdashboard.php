<?php
session_start();

// 🔴 DEBUG MODE (WAJIB SAAT ERROR)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= CEK ROLE =================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pemilik') {
    header('Location: index.php');
    exit;
}

// ================= KONEKSI =================
$conn = new mysqli("localhost","root","","warung");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ================= DATA =================
$today = date("Y-m-d");

// ================= PENJUALAN HARI INI =================
$q1 = $conn->query("
    SELECT IFNULL(SUM(total),0) as total
    FROM penjualan
    WHERE DATE(tanggal) = '$today'
");

if(!$q1){
    die("Error penjualan: ".$conn->error);
}
$penjualan = $q1->fetch_assoc();

// ================= JUMLAH TRANSAKSI =================
$q2 = $conn->query("
    SELECT COUNT(*) as jumlah
    FROM penjualan
    WHERE DATE(tanggal) = '$today'
");

if(!$q2){
    die("Error transaksi: ".$conn->error);
}
$transaksi = $q2->fetch_assoc();

// ================= PRODUK TERLARIS =================
$q3 = $conn->query("
    SELECT b.nama, SUM(d.jumlah) as terjual
    FROM detail_penjualan d
    JOIN barang b ON d.barang_id = b.id
    GROUP BY b.id, b.nama
    ORDER BY terjual DESC
    LIMIT 1
");

if(!$q3){
    die("Error produk terlaris: ".$conn->error);
}
$laris = $q3->fetch_assoc();

// ================= GRAFIK =================
$q4 = $conn->query("
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM penjualan
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC
");

if(!$q4){
    die("Error grafik: ".$conn->error);
}

$tanggal = [];
$total = [];

while($g = $q4->fetch_assoc()){
    $tanggal[] = $g['tgl'];
    $total[] = $g['total'];
}

// ================= PIE =================
$q5 = $conn->query("
    SELECT metode, SUM(total) as total
    FROM penjualan
    WHERE MONTH(tanggal) = MONTH(CURRENT_DATE())
    GROUP BY metode
");

if(!$q5){
    die("Error metode: ".$conn->error);
}

$labelMetode = [];
$dataMetode = [];

while($m = $q5->fetch_assoc()){
    $labelMetode[] = $m['metode'];
    $dataMetode[] = $m['total'];
}

// ================= STOK MENIPIS =================
$q6 = $conn->query("
    SELECT nama, stok
    FROM barang
    WHERE stok < 5
");

if(!$q6){
    die("Error stok: ".$conn->error);
}

// ================= AKTIVITAS =================
$q7 = $conn->query("
    SELECT *
    FROM penjualan
    ORDER BY tanggal DESC
    LIMIT 5
");

if(!$q7){
    die("Error aktivitas: ".$conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>
:root {
  --bg-main: #F7F3EE;
  --sidebar: #FFF8E1;
  --text-dark: #1A1A1A;
  --text-muted: #4A4A4A;
  --primary: #2E7D32;
  --soft-green: #C8E6C9;
  --card: #ffffff;
  --border: #e0e0e0;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", sans-serif;
}

body {
  background: var(--bg-main);
  color: var(--text-dark);
  display: flex;
  height: 100vh;
}

/* SIDEBAR */
.sidebar {
  width: 240px;
  background: var(--sidebar);
  padding: 24px 18px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-right: 1px solid var(--border);
}

.logo {
  font-size: 22px;
  font-weight: bold;
  color: var(--primary);
  margin-bottom: 20px;
}

.profile {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 30px;
}

.avatar {
  width: 48px;
  height: 48px;
  background: var(--soft-green);
  border-radius: 50%;
}

.menu {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.menu a {
  text-decoration: none;
  color: var(--text-dark);
  padding: 10px;
  border-radius: 8px;
}

.menu a.active,
.menu a:hover {
  background: var(--soft-green);
}

.logout {
  margin-top: 20px;
}

/* MAIN */
.main {
  flex: 1;
  padding: 30px;
  overflow-y: auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.welcome {
  font-size: 22px;
  font-weight: 600;
}

.search {
  background: #e0e0e0;
  border-radius: 20px;
  padding: 10px 16px;
  width: 260px;
  border: none;
}

/* CARD */
.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 20px;
}

.card {
  background: var(--card);
  border-radius: 12px;
  padding: 20px;
  border: 1px solid var(--border);
}

.card-title {
  color: var(--text-muted);
  margin-bottom: 10px;
}

.card-value {
  font-size: 24px;
  color: var(--primary);
  font-weight: bold;
}

/* GRID BAWAH */
.grid-2 {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

.grid-bottom {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 20px;
}

/* CHART PLACEHOLDER */
.chart {
  height: 200px;
  background: linear-gradient(135deg, #eee, #ddd);
  border-radius: 10px;
  margin-top: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-muted);
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
    <div>Arsita Dewi</div>
</div>

        <div class="menu">
            <a href="pemilikdashboard.php">Dashboard</a>
            <a href="pemiliklaporan.php">Laporan</a>
            <a href="pemilikkelolabarang.php">Barang</a>
            <a href="pemilikpenerimaan.php">Penerimaan</a>
            <a href="pemiliksupplier.php">Supplier</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!--MAIN-->
<div class="main">

  <!-- HEADER -->
  <div class="header">
    <div class="welcome">Selamat Datang, <?= $_SESSION['nama'] ?? 'Pemilik' ?></div>
    <input class="search" placeholder="Cari...">
  </div>

  <!-- 3 CARD ATAS -->
  <div class="grid-3">
    <div class="card">
      <div class="card-title">Penjualan Hari Ini</div>
      <div class="card-value">
        Rp <?= number_format($penjualan['total']) ?>
      </div>
    </div>

    <div class="card">
      <div class="card-title">Jumlah Transaksi</div>
      <div class="card-value">
        <?= $transaksi['jumlah'] ?>
      </div>
    </div>

    <div class="card">
      <div class="card-title">Produk Terlaris</div>
      <div class="card-value">
        <?= $laris['nama'] ?? 'Belum ada data' ?>
      </div>
    </div>
  </div>

  <!-- GRAFIK -->
  <div class="grid-2">
    <div class="card">
      <div class="card-title">Grafik Penjualan Harian</div>
      <canvas id="grafik"></canvas>
    </div>

    <div class="card">
      <div class="card-title">Komposisi Penjualan (Bulan ini)</div>
      <canvas id="pie"></canvas>
    </div>
  </div>

  <!-- BAGIAN BAWAH -->
  <div class="grid-bottom">
    <div class="card">
      <div class="card-title">Stok Menipis</div>

      <?php if($q6->num_rows > 0): ?>
        <?php while($s = $q6->fetch_assoc()): ?>
          <div><?= $s['nama'] ?> (<?= $s['stok'] ?>)</div>
        <?php endwhile; ?>
      <?php else: ?>
        <div>Semua aman</div>
      <?php endif; ?>

    </div>

    <div class="card">
      <div class="card-title">Aktivitas Terakhir</div>

      <?php while($a = $q7->fetch_assoc()): ?>
        <div>
          <?= $a['tanggal'] ?> - Rp <?= number_format($a['total']) ?>
        </div>
      <?php endwhile; ?>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// LINE CHART
new Chart(document.getElementById('grafik'), {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Penjualan',
            data: <?= json_encode($total) ?>,
            borderWidth: 2
        }]
    }
});

// PIE CHART
new Chart(document.getElementById('pie'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($labelMetode) ?>,
        datasets: [{
            data: <?= json_encode($dataMetode) ?>
        }]
    }
});
</script>

</body>
</html>