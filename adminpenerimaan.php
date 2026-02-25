<?php
// adminpenerimaan.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Penerimaan Barang</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
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
    font-weight:600;
}

.logout{
    margin-top:30px;
    color:#4A4A4A;
}

/* ================= MAIN ================= */

.main{
    flex:1;
    padding:40px;
}

.title{
    font-size:28px;
    font-weight:600;
    margin-bottom:30px;
}

/* ================= FORM ================= */

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:25px;
}

.form-group input,
.form-group select{
    width:100%;
    padding:12px;
    border-radius:12px;
    border:none;
    background:#E0E0E0;
}

/* ================= TABLE ================= */

.table-box{
    background:#DADADA;
    padding:20px;
    border-radius:18px;
    margin-bottom:25px;
}

.table-header{
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1fr;
    font-weight:600;
    margin-bottom:10px;
}

.table-body{
    height:150px;
    border-radius:15px;
    background:#F7F3EE;
    border:2px solid #CFCFCF;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#999;
}

/* ================= BUTTON ================= */

.btn-add{
    background:#4A4A4A;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:20px;
    cursor:pointer;
    margin-bottom:30px;
}

.bottom-section{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
}

.total-box{
    text-align:right;
}

.total-box input{
    padding:12px;
    border-radius:20px;
    border:none;
    background:#E0E0E0;
    width:200px;
}

.btn-save{
    background:#2E7D32;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:25px;
    margin-top:10px;
    cursor:pointer;
    font-weight:600;
}

.btn-save:hover{
    background:#256628;
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
            <a href="adminpenerimaan.php" class="active">Input Penerimaan</a>
            <a href="adminpo.php">Purchase Order</a>
            <a href="#">Laporan</a>
        </div>
    </div>

    <div class="logout">Logout</div>
</div>

<!-- MAIN -->
<div class="main">

    <div class="title">Penerimaan Barang</div>

    <form method="POST">

        <div class="form-grid">
            <div class="form-group">
                <select name="jenis">
                    <option>Jenis Barang</option>
                    <option>Bahan Baku</option>
                    <option>Produk Jadi</option>
                </select>
            </div>

            <div class="form-group">
                <select name="supplier">
                    <option>Nama Supplier</option>
                    <option>Supplier A</option>
                    <option>Supplier B</option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="invoice" placeholder="Nomor PO / Invoice">
            </div>

            <div class="form-group">
                <input type="date" name="tanggal">
            </div>
        </div>

        <div class="table-box">
            <div class="table-header">
                <div>Nama Barang</div>
                <div>Jumlah Diterima</div>
                <div>Harga Beli</div>
                <div>Subtotal</div>
            </div>

            <div class="table-body">
                Detail barang akan tampil di sini
            </div>
        </div>

        <h3 style="margin-bottom:10px;">Tambah Detail Barang</h3>
        <button type="button" class="btn-add">+ Tambah Item</button>

        <div class="bottom-section">
            <div></div>

            <div class="total-box">
                <div style="margin-bottom:8px;font-weight:600;">
                    Total Harga Penerimaan
                </div>
                <input type="text" placeholder="Rp">
                <br>
                <button type="submit" class="btn-save">
                    Verifikasi & Simpan
                </button>
            </div>
        </div>

    </form>
</div>

</body>
</html>