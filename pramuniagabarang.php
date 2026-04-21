<?php
session_start();

// CEK ROLE PRAMUNIAGA
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'pramuniaga') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "warung");

// QUERY SEMUA BARANG
$barang = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
<title>Daftar Barang</title>

<style>
body{
    display:flex;
    font-family:Segoe UI;
    background:#F7F3EE;
}

.sidebar{
    width:240px;
    background:#FFF8E1;
    padding:20px;
}

.menu a{
    display:block;
    padding:10px;
    text-decoration:none;
    color:#333;
}

.menu a:hover{
    background:#C8E6C9;
}

.main{
    flex:1;
    padding:30px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th, .table td{
    padding:10px;
    border-bottom:1px solid #eee;
}

.btn{
    padding:6px 12px;
    background:#2E7D32;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

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
    <div>Resti Putri</div>
</div>

        <div class="menu">
            <a href="pramuniagadashboard.php">Dashboard</a>
            <a href="pramuniagabarang.php">Barang</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>
<!-- MAIN -->
<div class="main">

<h2>Daftar Barang</h2>

<div class="card">
    <table class="table">
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while($b = $barang->fetch_assoc()): ?>
        <tr>
            <td><?= $b['nama'] ?></td>
            <td>Rp <?= number_format($b['harga']) ?></td>
            <td><?= $b['stok'] ?></td>
            <td>
                <button class="btn"
                onclick="printLabel('<?= $b['nama'] ?>','<?= number_format($b['harga']) ?>')">
                Print Label
                </button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</div>

<script>
function printLabel(nama, harga){

    let isi = `
    <div style="width:200px; text-align:center; font-family:Arial; border:1px solid #000; padding:10px;">
        <h3>${nama}</h3>
        <h2>Rp ${harga}</h2>
    </div>
    `;

    let win = window.open('', '_blank');
    win.document.write(`
        <html>
        <body onload="window.print();window.close();">
        ${isi}
        </body>
        </html>
    `);
    win.document.close();
}
</script>

</body>
</html>