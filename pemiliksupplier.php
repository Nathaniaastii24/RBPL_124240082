<?php
session_start();

// CEK ROLE PEMILIK
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'pemilik') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "warung");

// ================== TAMBAH ==================
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    $conn->query("INSERT INTO supplier (nama,kontak,alamat)
                  VALUES ('$nama','$kontak','$alamat')");

    header("Location: pemiliksupplier.php");
    exit;
}

// ================== UPDATE ==================
if (isset($_POST['update'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    $conn->query("UPDATE supplier 
                  SET nama='$nama', kontak='$kontak', alamat='$alamat'
                  WHERE id=$id");

    header("Location: pemiliksupplier.php");
    exit;
}

// ================== DELETE ==================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM supplier WHERE id=$id");

    header("Location: pemiliksupplier.php");
    exit;
}

// ================== EDIT MODE ==================
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = $conn->query("SELECT * FROM supplier WHERE id=$id")->fetch_assoc();
}

// ================== DATA ==================
$supplier = $conn->query("SELECT * FROM supplier ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Supplier</title>

<style>
body{
    display:flex;
    font-family:Segoe UI;
    background:#F7F3EE;
}

/* SIDEBAR */
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

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

input, textarea{
    width:100%;
    padding:8px;
    margin:5px 0;
}

.btn{
    padding:8px 15px;
    background:#2E7D32;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th, .table td{
    padding:10px;
    border-bottom:1px solid #eee;
}

:root {
  --bg-main: #F7F3EE;
  --sidebar: #FFF8E1;
  --text-dark: #1A1A1A;
  --text-muted: #4A4A4A;
  --primary: #2E7D32;
  --soft-green: #C8E6C9;
  --card: #ffffff;
  --border: #e0e0e0;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", sans-serif;
}

body {
  background: var(--bg-main);
  color: var(--text-dark);
  display: flex;
  height: 100vh;
}

/* SIDEBAR */
.sidebar {
  width: 240px;
  background: var(--sidebar);
  padding: 24px 18px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-right: 1px solid var(--border);
}

.logo {
  font-size: 22px;
  font-weight: bold;
  color: var(--primary);
  margin-bottom: 20px;
}

.profile {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 30px;
}

.avatar {
  width: 48px;
  height: 48px;
  background: var(--soft-green);
  border-radius: 50%;
}

.menu {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.menu a {
  text-decoration: none;
  color: var(--text-dark);
  padding: 10px;
  border-radius: 8px;
}

.menu a.active,
.menu a:hover {
  background: var(--soft-green);
}

.logout {
  margin-top: 20px;
}

/* MAIN */
.main {
  flex: 1;
  padding: 30px;
  overflow-y: auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.welcome {
  font-size: 22px;
  font-weight: 600;
}

.search {
  background: #e0e0e0;
  border-radius: 20px;
  padding: 10px 16px;
  width: 260px;
  border: none;
}

/* CARD */
.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 20px;
}

.card {
  background: var(--card);
  border-radius: 12px;
  padding: 20px;
  border: 1px solid var(--border);
}

.card-title {
  color: var(--text-muted);
  margin-bottom: 10px;
}

.card-value {
  font-size: 24px;
  color: var(--primary);
  font-weight: bold;
}

/* GRID BAWAH */
.grid-2 {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

.grid-bottom {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 20px;
}

/* CHART PLACEHOLDER */
.chart {
  height: 200px;
  background: linear-gradient(135deg, #eee, #ddd);
  border-radius: 10px;
  margin-top: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-muted);
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
    <div>Arsita Dewi</div>
</div>

        <div class="menu">
            <a href="pemilikdashboard.php">Dashboard</a>
            <a href="pemiliklaporan.php">Laporan</a>
            <a href="pemilikkelolabarang.php">Barang</a>
            <a href="pemilikpenerimaan.php">Penerimaan</a>
            <a href="pemiliksupplier.php">Supplier</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

<h2>Manajemen Supplier</h2>

<!-- FORM -->
<div class="card">
    <h3><?= $edit ? "Edit Supplier" : "Tambah Supplier" ?></h3>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

        <input type="text" name="nama" placeholder="Nama Supplier"
        value="<?= $edit['nama'] ?? '' ?>" required>

        <input type="text" name="kontak" placeholder="Kontak"
        value="<?= $edit['kontak'] ?? '' ?>">

        <textarea name="alamat" placeholder="Alamat"><?= $edit['alamat'] ?? '' ?></textarea>

        <br>

        <?php if($edit): ?>
            <button class="btn" name="update">Update</button>
        <?php else: ?>
            <button class="btn" name="simpan">Simpan</button>
        <?php endif; ?>

    </form>
</div>

<!-- TABEL -->
<div class="card">
    <h3>Daftar Supplier</h3>

    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php while($s = $supplier->fetch_assoc()): ?>
        <tr>
            <td><?= $s['nama'] ?></td>
            <td><?= $s['kontak'] ?></td>
            <td><?= $s['alamat'] ?></td>
            <td>
                <a href="?edit=<?= $s['id'] ?>">Edit</a> |
                <a href="?hapus=<?= $s['id'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</div>

</body>
</html>