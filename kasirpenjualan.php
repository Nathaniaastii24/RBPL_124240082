<?php
session_start();
$conn = new mysqli("localhost", "root", "", "warung");

// ================== SIMPAN TRANSAKSI ==================
if (isset($_POST['bayar'])) {

    $metode = $_POST['metode'];
    $total  = (int)$_POST['total'];

    //mulai transaction
    $conn->begin_transaction();

    try {

        // 1. simpan penjualan
        $conn->query("INSERT INTO penjualan (tanggal,total,metode)
                      VALUES (NOW(),'$total','$metode')");

        $id = $conn->insert_id;

        // 2. loop detail
        foreach ($_POST['barang'] as $i => $barang_id) {

            $jumlah = (int)$_POST['jumlah'][$i];
            $harga  = (int)$_POST['harga'][$i];
            $diskon = (int)$_POST['diskon'][$i];

            if ($jumlah <= 0 || $harga <= 0) continue;

            //cek stok dulu
            $cek = $conn->query("SELECT stok FROM barang WHERE id='$barang_id'");
            $data = $cek->fetch_assoc();

            if ($data['stok'] < $jumlah) {
                throw new Exception("Stok tidak cukup!");
            }

            $subtotal = ($jumlah * $harga) - $diskon;

            // insert detail
            $conn->query("INSERT INTO detail_penjualan
            (penjualan_id,barang_id,jumlah,harga,diskon,subtotal)
            VALUES ('$id','$barang_id','$jumlah','$harga','$diskon','$subtotal')");

            // update stok
            $conn->query("UPDATE barang
            SET stok = stok - $jumlah
            WHERE id='$barang_id'");
        }

        // ✅ semua berhasil
            $conn->commit();

        // pindah ke halaman struk
            header("Location: struk.php?id=".$id);
            exit;

    } catch (Exception $e) {

        //gagal -> rollback
        $conn->rollback();
        echo "<script>alert('".$e->getMessage()."');</script>";
    }
}

// ================== AMBIL DATA ==================
$barang = $conn->query("SELECT * FROM barang");

$struk = null;
$detail = [];

if (isset($_GET['struk'])) {
    $id = $_GET['struk'];

    $struk = $conn->query("SELECT * FROM penjualan WHERE id=$id")->fetch_assoc();

    $detail = $conn->query("
        SELECT d.*, b.nama 
        FROM detail_penjualan d
        JOIN barang b ON d.barang_id = b.id
        WHERE d.penjualan_id=$id
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Kasir</title>
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

body{display:flex;font-family:Segoe UI;background:#F7F3EE;}
.sidebar{width:220px;background:#FFF8E1;padding:20px;}
.main{flex:1;padding:20px;}
.table{width:100%;}
input,select{padding:6px;margin:5px;}
.btn{padding:8px 15px;border:none;border-radius:5px;cursor:pointer;}

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
    <div>Kurnia Fika</div>
</div>

        <div class="menu">
            <a href="kasirdashboard.php">Dashboard</a>
            <a href="kasirpenjualan.php" class="active">Penjualan</a>
            <a href="kasirtutup.php">Tutup Kasir</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>


<!--MAIN-->
<div class="main">

<h2>Penjualan</h2>

<form method="POST">

<button type="button" onclick="tambahItem()">+ Tambah Item</button>

<table class="table">
<tr>
<th>Barang</th>
<th>Jumlah</th>
<th>Harga</th>
<th>Diskon</th>
<th>Subtotal</th>
</tr>

<tbody id="tableBody"></tbody>
</table>

<br>
Total: <input type="text" id="total" name="total" readonly>

<br><br>

Metode:
<select name="metode">
    <option value="Tunai">Tunai</option>
    <option value="QRIS">QRIS</option>
</select>

<br><br>

<button type="submit" name="bayar" class="btn">Bayar</button>

</form>

</div>

<script>
function tambahItem(){
let row=`
<tr>
<td>
<select name="barang[]">
<?php 
$barang->data_seek(0);
while($b=$barang->fetch_assoc()): ?>
<option value="<?= $b['id'] ?>"><?= $b['nama'] ?></option>
<?php endwhile; ?>
</select>
</td>

<td><input type="number" name="jumlah[]" oninput="hitung(this)"></td>
<td><input type="number" name="harga[]" oninput="hitung(this)"></td>
<td><input type="number" name="diskon[]" value="0" oninput="hitung(this)"></td>
<td><input type="text" name="subtotal[]" readonly></td>
</tr>
`;
document.getElementById("tableBody").insertAdjacentHTML("beforeend",row);
}

function hitung(el){
let row=el.closest("tr");
let jumlah=row.querySelector('[name="jumlah[]"]').value;
let harga=row.querySelector('[name="harga[]"]').value;
let diskon=row.querySelector('[name="diskon[]"]').value;

let subtotal=(jumlah*harga)-(diskon||0);
row.querySelector('[name="subtotal[]"]').value=subtotal;

hitungTotal();
}

function hitungTotal(){
let total=0;
document.querySelectorAll('[name="subtotal[]"]').forEach(el=>{
total+=parseInt(el.value)||0;
});
document.getElementById("total").value=total;
}
</script>

<!--STRUK-->
<?php if($struk): ?>
<div id="struk" style="display:none;">
    <div style="width:250px; font-family:monospace;">
        <h3 style="text-align:center;">Warung Mbak Eni</h3>
        <p style="text-align:center;">Struk Pembelian</p>
        <hr>

        <p>Tanggal: <?= $struk['tanggal'] ?></p>
        <hr>

        <?php while($d = $detail->fetch_assoc()): ?>
            <div>
                <?= $d['nama'] ?><br>
                <?= $d['jumlah'] ?> x <?= number_format($d['harga']) ?>
                <span style="float:right;">
                    <?= number_format($d['subtotal']) ?>
                </span>
            </div>
        <?php endwhile; ?>

        <hr>
        <b>Total: Rp <?= number_format($struk['total']) ?></b><br>
        Metode: <?= $struk['metode'] ?>

        <hr>
        <p style="text-align:center;">Terima Kasih</p>
    </div>
</div>
<script>
window.onload = function() {
    let isi = document.getElementById("struk").innerHTML;

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
<?php endif; ?>
</body>


</html>