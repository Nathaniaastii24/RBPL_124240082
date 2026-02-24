<?php
// contoh data dinamis (nanti bisa dari database)
$totalPendapatan = 3250000;

$transaksi = [
    ["tanggal"=>"01-03-2026", "barang"=>"Bayam", "jumlah"=>5, "total"=>10000],
    ["tanggal"=>"01-03-2026", "barang"=>"Wortel", "jumlah"=>3, "total"=>9000],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Penjualan — Warung Mbak Eni</title>

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

.title {
  font-size: 24px;
  font-weight: 600;
}

/* CARD */
.card {
  background: var(--card);
  border-radius: 12px;
  padding: 20px;
  border: 1px solid var(--border);
  margin-bottom: 20px;
}

.summary {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.filters {
  display: flex;
  gap: 10px;
}

input, button {
  padding: 10px 12px;
  border-radius: 8px;
  border: 1px solid var(--border);
}

button {
  background: var(--primary);
  color: white;
  border: none;
  cursor: pointer;
}

/* CHART */
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

/* TABLE */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th, td {
  padding: 12px;
  border-bottom: 1px solid var(--border);
  text-align: left;
}

th {
  background: var(--soft-green);
}
</style>
</head>

<body>

<div class="sidebar">
  <div>
    <div class="logo">Warung Mbak Eni</div>

    <div class="profile">
      <div class="avatar"></div>
      <div>Nama Akun</div>
    </div>

    <div class="menu">
      <a href="dashboardpemilik.php">Dashboard</a>
      <a class="active" href="#">Laporan</a>
      <a href="#">Barang</a>
      <a href="#">Penerimaan</a>
      <a href="#">Supplier</a>
    </div>
  </div>

  <a class="logout" href="#">Logout</a>
</div>

<div class="main">

  <div class="header">
    <div class="title">Laporan Penjualan</div>
    <div>🔔</div>
  </div>

  <!-- TOTAL -->
  <div class="card summary">
    <div>
      <div>Total Pendapatan Bersih</div>
      <h2 style="color: var(--primary)">
        Rp <?= number_format($totalPendapatan, 0, ',', '.') ?>
      </h2>
    </div>

    <form method="GET" class="filters">
      <input type="date" name="mulai">
      <input type="date" name="akhir">
      <button type="submit">Filter</button>
    </form>
  </div>

  <!-- GRAFIK -->
  <div class="card">
    <div>Grafik Penjualan</div>
    <div class="chart">Area Grafik</div>
  </div>

  <!-- TABEL -->
  <div class="card">
    <div>Tabel Riwayat Transaksi</div>

    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($transaksi as $row): ?>
        <tr>
          <td><?= $row['tanggal'] ?></td>
          <td><?= $row['barang'] ?></td>
          <td><?= $row['jumlah'] ?></td>
          <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>

</div>

</body>
</html>