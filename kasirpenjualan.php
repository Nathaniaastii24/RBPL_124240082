<?php
// kasirpenjualan.php
$namaAkun = "Nama Akun"; // bisa diganti dari session login
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Penjualan - Kasir</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    display:flex;
    min-height:100vh;
    background:#F7F3EE;
    color:#1A1A1A;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:260px;
    background:#FFF8E1;
    padding:30px 20px;
    border-radius:0 25px 25px 0;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.brand{
    font-size:24px;
    font-weight:600;
    line-height:1.3;
    margin-bottom:30px;
}

.profile{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:40px;
}

.avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:#C8E6C9;
}

.menu{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.menu a{
    text-decoration:none;
    padding:12px 15px;
    border-radius:12px;
    color:#4A4A4A;
    transition:0.2s;
}

.menu a:hover{
    background:#C8E6C9;
    color:#1A1A1A;
}

.menu a.active{
    background:#C8E6C9;
    color:#1A1A1A;
    font-weight:600;
}

.logout{
    margin-top:30px;
    color:#4A4A4A;
    cursor:pointer;
}

/* ================= MAIN ================= */
.main{
    flex:1;
    padding:40px;
}

.top-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.title{
    font-size:28px;
    font-weight:600;
}

.icons{
    color:#4A4A4A;
    font-size:20px;
}

/* ================= TAMBAH ITEM BAR ================= */
.add-bar{
    width:100%;
    background:#D6D6D6;
    border-radius:30px;
    padding:10px;
    margin-bottom:20px;
}

.btn-add{
    background:#BDBDBD;
    border:none;
    padding:10px 20px;
    border-radius:25px;
    cursor:pointer;
    font-weight:500;
}

/* ================= TABLE BOX ================= */
.table-box{
    background:#BDBDBD;
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
}

.table-header{
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1fr 1fr;
    font-weight:600;
    margin-bottom:10px;
}

.table-body{
    height:200px;
    background:#E0E0E0;
    border-radius:15px;
    border:2px solid #CFCFCF;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#9E9E9E;
}

/* ================= TOTAL ================= */
.total-bar{
    width:100%;
    background:#D6D6D6;
    border-radius:15px;
    padding:12px 20px;
    font-weight:500;
    margin-bottom:20px;
}

/* ================= PAYMENT ================= */
.payment{
    margin-bottom:25px;
}

.payment-title{
    font-weight:500;
    margin-bottom:10px;
}

.payment-methods{
    display:flex;
    gap:15px;
}

.method-btn{
    background:#D6D6D6;
    border:none;
    padding:10px 25px;
    border-radius:25px;
    cursor:pointer;
    font-weight:500;
}

.method-btn:hover{
    background:#C8E6C9;
}

/* ================= PAY BUTTON ================= */
.pay-btn{
    background:#4A4A4A;
    color:white;
    border:none;
    padding:14px 30px;
    border-radius:30px;
    font-weight:600;
    cursor:pointer;
}

.pay-btn:hover{
    background:#2E7D32;
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
            <a href="kasirdashboard.php">Dashboard</a>
            <a href="kasirpenjualan.php" class="active">Penjualan</a>
            <a href="tutupkasir.php">Tutup Kasir</a>
        </div>
    </div>

    <div class="logout">Logout</div>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="top-header">
        <div class="title">Penjualan</div>
        <div class="icons">🔔 ⋮</div>
    </div>

    <!-- TAMBAH ITEM -->
    <div class="add-bar">
        <button class="btn-add">+ Tambah Item</button>
    </div>

    <!-- TABEL PENJUALAN -->
    <div class="table-box">
        <div class="table-header">
            <div>Nama Barang</div>
            <div>Jumlah</div>
            <div>Harga Satuan</div>
            <div>Diskon</div>
            <div>Subtotal</div>
        </div>

        <div class="table-body">
            Item penjualan akan tampil di sini
        </div>
    </div>

    <!-- TOTAL -->
    <div class="total-bar">
        Total Pembelian
    </div>

    <!-- METODE PEMBAYARAN -->
    <div class="payment">
        <div class="payment-title">Metode Pembayaran</div>
        <div class="payment-methods">
            <button class="method-btn">Tunai</button>
            <button class="method-btn">Qris</button>
        </div>
    </div>

    <!-- BUTTON BAYAR -->
    <button class="pay-btn">Bayar & Cetak Struk</button>

</div>

</body>
</html>