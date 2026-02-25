<?php
$namaAkun = "Admin";

// contoh data dummy (nanti dari database)
$dataBarang = [
    ["id" => "BRG001", "nama" => "Tomat", "stok" => 20, "harga" => 5000],
    ["id" => "BRG002", "nama" => "Bayam", "stok" => 12, "harga" => 3000],
    ["id" => "BRG003", "nama" => "Cabai", "stok" => 5, "harga" => 25000],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Inventaris Barang</title>

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

.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
}

.menu a:hover {
    background: #C8E6C9;
}

.logout {
    margin-top: 20px;
}

/* ===== MAIN ===== */
.main {
    flex: 1;
    padding: 25px;
}

.title {
    font-size: 22px;
    font-weight: 600;
    color: #1A1A1A;
    margin-bottom: 15px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn {
    background: #2E7D32;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 20px;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.9;
}

/* ===== TABLE ===== */
.card {
    background: white;
    border-radius: 14px;
    padding: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    text-align: left;
    padding: 12px;
    color: #1A1A1A;
}

.table td {
    padding: 12px;
    border-top: 1px solid #eee;
    color: #4A4A4A;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    margin-right: 5px;
}

.edit {
    background: #C8E6C9;
}

.delete {
    background: #FFDADA;
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
            <a href="admindashboard.php">Dashboard</a>
            <a href="#" class="active">Kelola Barang</a>
            <a href="adminpenerimaan.php">Input Penerimaan</a>
            <a href="#">Purchase Order</a>
            <a href="#">Laporan</a>
        </div>
    </div>

    <div class="logout">
        <a href="#">Logout</a>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main">

    <div class="topbar">
        <div class="title">Kelola Inventaris Barang</div>
        <button class="btn">+ Tambah Barang</button>
    </div>

    <div class="card">
        <h3 style="margin-bottom:10px;">Daftar Barang</h3>

        <table class="table">
            <tr>
                <th>ID Barang</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>

            <?php foreach($dataBarang as $barang): ?>
            <tr>
                <td><?= $barang['id']; ?></td>
                <td><?= $barang['nama']; ?></td>
                <td><?= $barang['stok']; ?></td>
                <td>Rp <?= number_format($barang['harga'],0,",","."); ?></td>
                <td>
                    <button class="action-btn edit">Edit</button>
                    <button class="action-btn delete">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

</body>
</html>