<?php
session_start();

// Simulasi nama akun (nanti bisa ambil dari database / session login)
$namaAkun = "Pramuniaga";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Warung Mbak Eni</title>
    <style>
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
            width: 250px;
            height: 100vh;
            background-color: #F7F3EE;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .profile {
            margin-bottom: 30px;
            color: #4A4A4A;
        }

        .menu a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            text-decoration: none;
            color: #4A4A4A;
            border-radius: 8px;
        }

        .menu a:hover,
        .menu a.active {
            background-color: #C8E6C9;
            color: #2E7D32;
            font-weight: bold;
        }

        .logout {
            text-decoration: none;
            font-weight: bold;
            color: #2E7D32;
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

    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div>
            <h2>Warung<br>Mbak Eni</h2>

            <div class="profile">
                <strong>Nama Akun</strong><br>
                <?= $namaAkun ?>
            </div>

            <div class="menu">
                <a href="#" class="active">Dashboard</a>
                <a href="#">Barang</a>
            </div>
        </div>

        <a href="#" class="logout">Logout</a>
    </div>

    <!-- ===== MAIN ===== -->
    <div class="main">
        <div class="header">
            Selamat Datang, <?= $namaAkun; ?>
        </div>

        <!-- GRID ATAS -->
        <div class="grid">
            <div class="card">
                <h4>Informasi Stok Barang</h4>
                <div class="card-content"></div>
            </div>

            <div class="card">
                <h4>Status Inventaris Cepat</h4>
                <div class="card-content"></div>
            </div>
        </div>

        <!-- GRID BAWAH -->
        <div class="grid-bottom">
            <div class="card">
                <h4>Notifikasi Barang Masuk Hari ini</h4>
                <div class="card-content" style="height: 220px;"></div>
            </div>

            <div class="card">
                <h4>Stok Menipis</h4>
                <div class="card-content"></div>
            </div>

            <div class="card card-large">
                <h4>Tren Penjualan</h4>
                <div class="card-content"></div>
            </div>
        </div>

    </div>

</body>
</html>