<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "warung");

// SIMPAN DATA
if (isset($_POST['simpan'])) {

    $supplier = $_POST['supplier'];
    $jenis    = $_POST['jenis'];
    $invoice  = $_POST['invoice'];
    $tanggal  = $_POST['tanggal'];
    $total    = $_POST['total'];

    $conn->query("INSERT INTO penerimaan (supplier,jenis,invoice,tanggal,total)
                  VALUES ('$supplier','$jenis','$invoice','$tanggal','$total')");

    $penerimaan_id = $conn->insert_id;

    foreach ($_POST['barang'] as $i => $barang_id) {
        $jumlah = $_POST['jumlah'][$i];
        $harga  = $_POST['harga'][$i];
        $subtotal = $jumlah * $harga;

        $conn->query("INSERT INTO detail_penerimaan 
        (penerimaan_id,barang_id,jumlah,harga,subtotal)
        VALUES ('$penerimaan_id','$barang_id','$jumlah','$harga','$subtotal')");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
exit;
}

// AMBIL DATA BARANG
$barang = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Penerimaan Barang</title>

<style>
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

body {display:flex; font-family:Segoe UI; background:#F7F3EE;}
.sidebar {width:240px; background:#FFF8E1; padding:20px;}
.menu a {display:block; padding:10px; text-decoration:none; color:#333;}
.menu a:hover {background:#C8E6C9;}
.main {flex:1; padding:25px;}
.card {background:#fff; padding:15px; border-radius:10px; margin-bottom:20px;}
input, select {padding:8px; margin:5px; width:100%;}
.table {width:100%; border-collapse:collapse;}
.table th, .table td {padding:10px; border-bottom:1px solid #eee;}
.btn {background:#2E7D32; color:white; padding:8px 15px; border:none; border-radius:6px; cursor:pointer;}
.btn-add {background:#444;}
.total-box {text-align:right;}
</style>
</head>

<body>

<!--SIDEBAR-->
<div class="sidebar">
    <div>
        <div class="logo">Warung Mbak Eni</div>

        <div class="profile">
            <div class="profile-circle"></div>
            <div>Nama Akun</div>
        </div>

        <div class="menu">
            <a href="admindashboard.php">Dashboard</a>
            <a href="#">Kelola Barang</a>
            <a href="adminpenerimaan.php">Input Penerimaan</a>
            <a href="adminpo.php">Purchase Order</a>
            <a href="#">Laporan</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

<h2>Penerimaan Barang</h2>

<form method="POST">

<!-- FORM UTAMA -->
<div class="card">
    <h3>Data Penerimaan</h3>

    <select name="jenis" required>
        <option value="">Pilih Jenis</option>
        <option>Sayuran</option>
        <option>Sembako</option>
    </select>

    <select name="supplier" required>
        <option value="">Pilih Supplier</option>
        <option>Kebun Makmur</option>
        <option>Mitra Sembako</option>
        <option>Sumber Rezeki</option>
        <option>Tani Jaya</option>
    </select>

    <input type="text" name="invoice" placeholder="No Invoice" required>
    <input type="date" name="tanggal" required>
</div>

<!-- TABEL -->
<div class="card">
    <h3>Detail Barang</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>

    <button type="button" class="btn btn-add" onclick="tambahItem()">+ Tambah Item</button>
</div>

<!-- TOTAL -->
<div class="card total-box">
    <h3>Total</h3>
    <input type="text" id="total" name="total" readonly>
    <br><br>
    <button type="submit" name="simpan" class="btn">Simpan</button>
</div>

</form>

</div>

<script>
function tambahItem() {
    let row = `
    <tr>
        <td>
            <select name="barang[]">
                <?php 
                $barang->data_seek(0);
                while($b = $barang->fetch_assoc()): ?>
                    <option value="<?= $b['id'] ?>"><?= $b['nama'] ?></option>
                <?php endwhile; ?>
            </select>
        </td>
        <td><input type="number" name="jumlah[]" oninput="hitung(this)"></td>
        <td><input type="number" name="harga[]" oninput="hitung(this)"></td>
        <td><input type="text" name="subtotal[]" readonly></td>
    </tr>
    `;
    document.getElementById("tableBody").insertAdjacentHTML("beforeend", row);
}

function hitung(el) {
    let row = el.closest("tr");
    let jumlah = row.querySelector('[name="jumlah[]"]').value;
    let harga  = row.querySelector('[name="harga[]"]').value;
    let subtotal = jumlah * harga;

    row.querySelector('[name="subtotal[]"]').value = subtotal;

    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('[name="subtotal[]"]').forEach(el => {
        total += parseInt(el.value) || 0;
    });

    document.getElementById("total").value = total;
}
</script>

</body>
</html>