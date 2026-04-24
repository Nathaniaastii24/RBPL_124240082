<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "warung");

// TAMBAH DATA
if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $conn->query("INSERT INTO barang (kode_barang,nama,stok,harga) 
                  VALUES ('$kode','$nama','$stok','$harga')");
    header("Location: adminkelolabarang.php");
}

// HAPUS
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM barang WHERE id=$id");
    header("Location: adminkelolabarang.php");
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $conn->query("UPDATE barang SET 
        kode_barang='$kode',
        nama='$nama',
        stok='$stok',
        harga='$harga'
        WHERE id=$id");

    header("Location: adminkelolabarang.php");
}

// AMBIL DATA
$data = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Barang</title>

<style>
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
body {font-family: Segoe UI; background:#F7F3EE; display:flex;}
.sidebar {width:220px; background:#FFF8E1; padding:20px;}
.menu a {display:block; padding:10px; text-decoration:none; color:#333;}
.menu a:hover {background:#C8E6C9;}
.main {flex:1; padding:20px;}
.card {background:white; padding:15px; border-radius:10px;}
.table {width:100%; border-collapse:collapse;}
.table th, .table td {padding:10px; border-bottom:1px solid #eee;}
.btn {background:#2E7D32; color:white; padding:8px 15px; border:none; border-radius:6px; cursor:pointer;}
.delete {background:red; color:white;}
.edit {background:orange; color:white;}
input {padding:8px; margin:5px;}
#formEdit {display:none; background:#fff; padding:15px; border:1px solid #ccc; margin-top:15px;}

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
            <a href="pemilikkelolabarang.php" class="active">Barang</a>
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

    <h2>Kelola Barang</h2>

    <!-- FORM TAMBAH -->
    <div class="card">
        <h3>Tambah Barang</h3>
        <form method="POST">
            <input type="text" name="kode" placeholder="Kode Barang" required>
            <input type="text" name="nama" placeholder="Nama Barang" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <button type="submit" name="tambah" class="btn">Tambah</button>
        </form>
    </div>

    <br>

    <!-- TABEL -->
    <div class="card">
        <h3>Daftar Barang</h3>
        <table class="table">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>

            <?php while($row = $data->fetch_assoc()): ?>
            <tr>
                <td><?= $row['kode_barang']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['stok']; ?></td>
                <td>Rp <?= number_format($row['harga'],0,",","."); ?></td>
                <td>
                    <button class="edit" onclick="editData('<?= $row['id'] ?>','<?= $row['kode_barang'] ?>','<?= $row['nama'] ?>','<?= $row['stok'] ?>','<?= $row['harga'] ?>')">Edit</button>
                    
                    <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">
                        <button class="delete">Hapus</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- FORM EDIT -->
    <div id="formEdit">
        <h3>Edit Barang</h3>
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="kode" id="editKode" required>
            <input type="text" name="nama" id="editNama" required>
            <input type="number" name="stok" id="editStok" required>
            <input type="number" name="harga" id="editHarga" required>
            <button type="submit" name="update" class="btn">Update</button>
        </form>
    </div>

</div>

<script>
function editData(id,kode,nama,stok,harga){
    document.getElementById('formEdit').style.display = 'block';
    document.getElementById('editId').value = id;
    document.getElementById('editKode').value = kode;
    document.getElementById('editNama').value = nama;
    document.getElementById('editStok').value = stok;
    document.getElementById('editHarga').value = harga;
}
</script>

</body>
</html>