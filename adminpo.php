<?php
session_start();
$conn = new mysqli("localhost", "root", "", "warung");

// SIMPAN PO
if (isset($_POST['simpan'])) {

    $supplier = $_POST['supplier'];
    $tanggal  = $_POST['tanggal'];
    $total    = $_POST['total'];

    $conn->query("INSERT INTO po (supplier,tanggal,total) 
                  VALUES ('$supplier','$tanggal','$total')");

    $po_id = $conn->insert_id;

    foreach ($_POST['barang'] as $i => $barang_id) {
        $jumlah = $_POST['jumlah'][$i];
        $harga  = $_POST['harga'][$i];
        $subtotal = $jumlah * $harga;

        $conn->query("INSERT INTO detail_po 
        (po_id,barang_id,jumlah,harga,subtotal)
        VALUES ('$po_id','$barang_id','$jumlah','$harga','$subtotal')");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
exit;
}

// UBAH STATUS
if (isset($_GET['kirim'])) {
    $id = $_GET['kirim'];
    $conn->query("UPDATE po SET status='Terkirim' WHERE id=$id");
    header("Location: adminpo.php");
    exit;
}

// AMBIL DATA
$barang = $conn->query("SELECT * FROM barang");
$dataPO = $conn->query("SELECT * FROM po ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Purchase Order</title>

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

body {display:flex; background:#F7F3EE; font-family:Segoe UI;}
.sidebar {width:240px; background:#FFF8E1; padding:20px;}
.menu a {display:block; padding:10px; text-decoration:none; color:#333;}
.menu a:hover {background:#C8E6C9;}
.main {flex:1; padding:25px;}
.card {background:#fff; padding:15px; border-radius:10px; margin-bottom:20px;}
.table {width:100%; border-collapse:collapse;}
.table th, .table td {padding:10px; border-bottom:1px solid #eee;}
.btn {padding:6px 12px; border:none; border-radius:6px; cursor:pointer;}
.add {background:#444; color:#fff;}
.save {background:#2E7D32; color:#fff;}
.kirim {background:orange;}
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

<h2>Purchase Order</h2>

<!-- FORM BUAT PO -->
<div class="card">
<h3>Buat PO</h3>

<form method="POST">
    <input type="text" name="supplier" placeholder="Nama Supplier" required>
    <input type="date" name="tanggal" required>

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

    <button type="button" class="btn add" onclick="tambahItem()">+ Tambah Item</button>

    <br><br>
    Total: <input type="text" id="total" name="total" readonly>

    <br><br>
    <button type="submit" name="simpan" class="btn save">Simpan PO</button>
</form>
</div>

<!-- TABEL PO -->
<div class="card">
<h3>Daftar PO</h3>

<table class="table">
<tr>
    <th>ID</th>
    <th>Supplier</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($po = $dataPO->fetch_assoc()): ?>
<tr>
    <td><?= $po['id'] ?></td>
    <td><?= $po['supplier'] ?></td>
    <td><?= $po['tanggal'] ?></td>
    <td>Rp <?= number_format($po['total'],0,",",".") ?></td>
    <td><?= $po['status'] ?></td>
    <td>
        <?php if($po['status'] == 'Draft'): ?>
            <a href="?kirim=<?= $po['id'] ?>">
                <button class="btn kirim">Kirim</button>
            </a>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

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