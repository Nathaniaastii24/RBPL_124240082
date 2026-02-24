<?php
// contoh data dinamis
$namaAkun = "Nama Akun";
$penjualanHariIni = 450000;
$jumlahTransaksi = 18;
$produkTerlaris = "Bayam";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — Warung Mbak Eni</title>

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
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div>
    <div class="logo">Warung Mbak Eni</div>

    <div class="profile">
      <div class="avatar"></div>
      <div><?= $namaAkun ?></div>
    </div>

    <div class="menu">
      <a class="active" href="#">Dashboard</a>
      <a href="laporanpenjualan.php">Laporan</a>
      <a href="#">Barang</a>
      <a href="#">Penerimaan</a>
      <a href="#">Supplier</a>
    </div>
  </div>

  <a class="logout" href="#">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

  <div class="header">
    <div class="welcome">Selamat Datang, <?= $namaAkun ?></div>
    <input class="search" placeholder="Cari...">
    <div>🔔</div>
  </div>

  <!-- 3 KARTU -->
  <div class="grid-3">
    <div class="card">
      <div class="card-title">Penjualan Hari Ini</div>
      <div class="card-value">
        Rp <?= number_format($penjualanHariIni,0,',','.') ?>
      </div>
    </div>

    <div class="card">
      <div class="card-title">Jumlah Transaksi</div>
      <div class="card-value"><?= $jumlahTransaksi ?></div>
    </div>

    <div class="card">
      <div class="card-title">Produk Terlaris</div>
      <div class="card-value"><?= $produkTerlaris ?></div>
    </div>
  </div>

  <!-- GRAFIK -->
  <div class="grid-2">
    <div class="card">
      <div>Grafik Penjualan Harian</div>
      <div class="chart">Area Grafik</div>
    </div>

    <div class="card">
      <div>Komposisi Penjualan (Bulan ini)</div>
      <div class="chart">Pie Chart</div>
    </div>
  </div>

  <!-- BAWAH -->
  <div class="grid-bottom">
    <div class="card">
      <div>Stok Menipis</div>
      <div class="chart">Daftar Barang</div>
    </div>

    <div class="card">
      <div>Aktivitas Terakhir</div>
      <div class="chart">Riwayat Aktivitas</div>
    </div>
  </div>

</div>

</body>
</html>