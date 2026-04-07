<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: index.php'); exit;
}
?>

<?php
// contoh data dinamis (nanti bisa dari database)
$namaAkun = "Admin";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Warung Mbak Eni</title>

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
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <div>
        <div class="logo">Warung Mbak Eni</div>

        <div class="profile">
            <div class="profile-circle"></div>
            <div>Nama Akun</div>
        </div>

        <div class="menu">
            <a href="#">Dashboard</a>
            <a href="adminkelolabarang.php">Kelola Barang</a>
            <a href="adminpenerimaan.php">Input Penerimaan</a>
            <a href="#">Purchase Order</a>
            <a href="#">Laporan</a>
        </div>
    </div>

    <div class="logout">
        <a href="#">Logout</a>
    </div>
</div>

<!-- ===== MAIN ===== -->
<div class="main">
    <div class="topbar">
        <div class="welcome">
            Selamat Datang, <?php echo $namaAkun; ?>
        </div>
        <input class="search" placeholder="Cari...">
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-title">Grafik Penjualan Harian</div>
            <div class="placeholder"></div>
        </div>

        <div class="card">
            <div class="card-title">Ringkasan Stok Barang</div>
            <div class="placeholder"></div>
        </div>
    </div>

    <div class="grid-bottom">
        <div class="card">
            <div class="card-title">Stok Menipis</div>
            <div class="placeholder"></div>
        </div>

        <div class="card">
            <div class="card-title">Ringkasan Stok Barang</div>
            <div class="placeholder"></div>
        </div>
    </div>
</div>

</body>
</html>