<?php
session_start();
$conn = new mysqli("localhost", "root", "", "warung");

// ambil data hari ini
$tanggal = date('Y-m-d');

// total semua
$data = $conn->query("
    SELECT 
        COUNT(*) as jumlah,
        SUM(total) as total,
        SUM(CASE WHEN metode='Tunai' THEN total ELSE 0 END) as tunai,
        SUM(CASE WHEN metode='QRIS' THEN total ELSE 0 END) as qris
    FROM penjualan
    WHERE DATE(tanggal) = '$tanggal'
")->fetch_assoc();

if(isset($_POST['tutup'])){

    $user = "Kasir"; // bisa ambil dari session

    $conn->query("
        INSERT INTO tutup_kasir 
        (user,tanggal,total_penjualan,jumlah_transaksi,total_tunai,total_qris,waktu_tutup)
        VALUES 
        ('$user','$tanggal',
        '{$data['total']}',
        '{$data['jumlah']}',
        '{$data['tunai']}',
        '{$data['qris']}',
        NOW())
    ");

    echo "<script>alert('Kasir berhasil ditutup!'); window.location='kasirdashboard.php';</script>";
}
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

/* WRAPPER BIAR CENTER DI AREA MAIN */
.center-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

/* CARD STYLE */
.custom-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    background: #fff;
}

/* HEADER */
.card-header {
    background: #2E7D32;
    color: white;
    font-weight: 600;
    text-align: center;
    padding: 12px;
}

/* LIST */
.list-group-item {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

/* BUTTON */
.btn {
    padding: 10px 20px;
    background: #2E7D32;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    background: #1b5e20;
}

.custom-card {
    width: 500px;
    max-width: 90%;
    min-height: 400px; /* biar tinggi cukup */
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);

    display: flex;
    flex-direction: column;
    justify-content: center;   /* center vertikal */
    align-items: center;       /* center horizontal */
    text-align: center;        /* teks rata tengah */
}

/* biar jarak antar teks enak */
.content {
    margin: 20px 0;
}

.content p {
    margin: 8px 0;
    font-size: 16px;
}

/* tombol biar di tengah */
.form-btn {
    margin-top: 20px;
}

/* JUDUL */
.title {
    text-align: center;
    margin-bottom: 20px;
}

/* ISI */
.content p {
    margin: 10px 0;
    font-size: 15px;
}

/* BUTTON DI BAWAH */
.form-btn {
    margin-top: 20px;
    text-align: center;
}

/* BUTTON */
.btn {
    padding: 10px 25px;
    background: #2E7D32;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    background: #1b5e20;
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
            <a href="kasirtutup.php" class="active">Tutup Kasir</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="center-wrapper">

        <div class="card custom-card">

            <h2 class="title">Tutup Kasir Hari Ini</h2>

            <div class="content">
                <p>Total Transaksi: <b><?= $data['jumlah'] ?></b></p>
                <p>Total Penjualan: <b>Rp <?= number_format($data['total']) ?></b></p>
                <p>Tunai: <b>Rp <?= number_format($data['tunai']) ?></b></p>
                <p>QRIS: <b>Rp <?= number_format($data['qris']) ?></b></p>
            </div>

            <form method="POST" class="form-btn">
                <button type="submit" name="tutup" class="btn">
                    Tutup Kasir
                </button>
            </form>

        </div>

    </div>

</div>

</body>
</html>