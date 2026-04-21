<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Kasir') {
    header('Location: index.php'); exit;
}
?>

<?php
// kasirdashboard.php
$namaAkun = "Nama Akun"; // nanti bisa diganti dari session login
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Kasir</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    display: flex;
    min-height: 100vh;
    background-color: #F7F3EE;
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

.brand {
    font-size: 24px;
    font-weight: 600;
    line-height: 1.3;
    margin-bottom: 30px;
}

.profile {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 40px;
}

.avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #C8E6C9;
}

.menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.menu a {
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 12px;
    color: #4A4A4A;
    font-size: 15px;
    transition: 0.2s;
}

.menu a:hover {
    background-color: #C8E6C9;
    color: #1A1A1A;
}

.menu a.active {
    background-color: #C8E6C9;
    color: #1A1A1A;
    font-weight: 600;
}

.logout {
    margin-top: 30px;
    color: #4A4A4A;
    cursor: pointer;
}

/* ================= MAIN CONTENT ================= */
.main {
    flex: 1;
    padding: 40px;
}

.top-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.welcome {
    font-size: 28px;
    font-weight: 600;
}

.icons {
    font-size: 20px;
    color: #4A4A4A;
}

/* ================= CARD ================= */
.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 35px;
}

.card {
    background-color: #BDBDBD;
    border-radius: 18px;
    padding: 20px;
    height: 110px;
    display: flex;
    align-items: flex-start;
    font-weight: 500;
    color: #1A1A1A;
}

/* ================= SECTION TITLE ================= */
.section-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* ================= HISTORY BOX ================= */
.history-box {
    background-color: #BDBDBD;
    border-radius: 18px;
    padding: 20px;
}

.history-title {
    font-weight: 600;
    margin-bottom: 10px;
}

.history-content {
    height: 250px;
    background-color: #E0E0E0;
    border-radius: 15px;
    border: 2px solid #CFCFCF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9E9E9E;
    font-size: 16px;
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
    <div>Kurnia Fika</div>
</div>

        <div class="menu">
            <a href="kasirdashboard.php">Dashboard</a>
            <a href="kasirpenjualan.php">Penjualan</a>
            <a href="kasirtutup.php">Tutup Kasir</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="top-header">
        <div class="welcome">
            Selamat Datang, Kurnia Fika <!--<?php echo $namaAkun; ?>-->
        </div>
        <div class="icons">
            🔔 ⋮
        </div>
    </div>

    <!-- CARD ATAS -->
    <div class="card-grid">
        <div class="card">Status Kasir</div>
        <div class="card">Total Transaksi</div>
        <div class="card">Produk Terlaris</div>
    </div>

    <!-- RINGKASAN -->
    <div class="section-title">Ringkasan Hari Ini</div>

    <div class="card-grid">
        <div class="card">Total Penjualan</div>
        <div class="card">Jumlah Transaksi</div>
        <div class="card">Metode Pembayaran</div>
    </div>

    <!-- RIWAYAT TRANSAKSI -->
    <div class="history-box">
        <div class="history-title">Riwayat Transaksi</div>
        <div class="history-content">
            Riwayat transaksi akan tampil di sini
        </div>
    </div>

</div>

</body>
</html>