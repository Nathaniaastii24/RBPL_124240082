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

/* ================= SIDEBAR ================= */
.sidebar {
    width: 260px;
    background-color: #FFF8E1;
    padding: 30px 20px;
    border-radius: 0 25px 25px 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
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
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <div class="brand">Warung<br>Mbak Eni</div>

        <div class="profile">
            <div class="avatar"></div>
            <div><?php echo $namaAkun; ?></div>
        </div>

        <div class="menu">
            <a href="kasirdashboard.php" class="active">Dashboard</a>
            <a href="kasirpenjualan.php">Penjualan</a>
            <a href="tutupkasir.php">Tutup Kasir</a>
        </div>
    </div>

    <div class="logout">Logout</div>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="top-header">
        <div class="welcome">
            Selamat Datang, <?php echo $namaAkun; ?>
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