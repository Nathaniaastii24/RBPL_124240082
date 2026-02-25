<?php
// adminpo.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - Warung Mbak Eni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #F7F3EE;
            color: #1A1A1A;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: #FFF8E1;
            padding: 30px 20px;
            border-radius: 0 20px 20px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            line-height: 1.3;
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

        /* MAIN CONTENT */
        .main {
            flex: 1;
            padding: 40px;
        }

        .header {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* TOP BAR */
        .top-bar {
            background-color: #E0E0E0;
            border-radius: 30px;
            padding: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .btn-po {
            background-color: #BDBDBD;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
        }

        /* FILTER BUTTON */
        .filter {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .filter button {
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            background-color: #D6D6D6;
            cursor: pointer;
            font-weight: 500;
        }

        .filter button.active {
            background-color: #C8E6C9;
            color: #1A1A1A;
        }

        /* TABLE BOX */
        .table-container {
            background-color: #D6D6D6;
            border-radius: 15px;
            padding: 20px;
        }

        .table-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 10px;
        }

        .table-body {
            height: 320px;
            border-radius: 15px;
            background-color: #EDEDED;
            border: 2px solid #BDBDBD;
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
                <div>Nama<br>Akun</div>
            </div>

            <div class="menu">
                <a href="admindashboard.php">Dashboard</a>
                <a href="adminkelolabarang.php">Kelola Barang</a>
                <a href="adminpenerimaan.php">Input Penerimaan</a>
                <a href="adminpo.php" class="active">Purchase Order</a>
                <a href="#">Laporan</a>
            </div>
        </div>

        <div class="logout">Logout</div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="header">Purchase Order</div>

        <div class="top-bar">
            <button class="btn-po">+ Buat PO</button>
        </div>

        <div class="filter">
            <button class="active">Draft</button>
            <button>Terkirim</button>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div>Daftar Purchase Order</div>
                <div>Tanggal PO</div>
                <div>Total Harga</div>
                <div>Status</div>
                <div>Aksi</div>
            </div>

            <div class="table-body">
                Data Purchase Order akan tampil di sini
            </div>
        </div>
    </div>

</body>
</html>