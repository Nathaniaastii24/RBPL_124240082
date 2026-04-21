<?php
// ================== KONEKSI ==================
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli("localhost", "root", "", "warung");

// ================== VALIDASI ID ==================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID transaksi tidak valid");
}

$id = (int)$_GET['id'];

// ================== AMBIL DATA ==================
$stmt = $conn->prepare("SELECT * FROM penjualan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$struk = $stmt->get_result()->fetch_assoc();

if (!$struk) {
    die("Data transaksi tidak ditemukan");
}

$stmt2 = $conn->prepare("
    SELECT d.*, b.nama 
    FROM detail_penjualan d
    JOIN barang b ON d.barang_id = b.id
    WHERE d.penjualan_id = ?
");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$detail = $stmt2->get_result();

// format nomor transaksi
$no_transaksi = "TRX-" . str_pad($struk['id'], 5, "0", STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pembelian</title>

<style>
body {
    font-family: monospace;
    background: #fff;
    display: flex;
    justify-content: center;
    padding: 20px;
}

.struk {
    width: 260px; /* cocok thermal */
}

.center { text-align: center; }
.right { text-align: right; }

hr {
    border: 0;
    border-top: 1px dashed #000;
    margin: 8px 0;
}

.item {
    margin-bottom: 5px;
}
</style>
</head>

<body>

<div class="struk">

    <div class="center">
        <h3>Warung Mbak Eni</h3>
        <small>Struk Pembelian</small>
    </div>

    <hr>

    <div>No: <?= $no_transaksi ?></div>
    <div>Tgl: <?= $struk['tanggal'] ?></div>

    <hr>

    <?php while($d = $detail->fetch_assoc()): ?>
        <div class="item">
            <?= $d['nama'] ?><br>
            <?= $d['jumlah'] ?> x <?= number_format($d['harga']) ?>
            <span class="right" style="float:right;">
                <?= number_format($d['subtotal']) ?>
            </span>
        </div>
    <?php endwhile; ?>

    <div style="clear:both;"></div>

    <hr>

    <div>
        <b>Total</b>
        <span style="float:right;">
            Rp <?= number_format($struk['total']) ?>
        </span>
    </div>

    <div>
        Metode:
        <span style="float:right;">
            <?= $struk['metode'] ?>
        </span>
    </div>

    <div style="clear:both;"></div>

    <hr>

    <div class="center">
        Terima Kasih Atas Kunjungannya<br>
        Semoga Anda Puas
        Ditunggu Kedatangannya Kembali
    </div>

    <br>

    <!-- tombol -->
    <div class="center">
        <button onclick="window.print()">Print</button>
        <br><br>
        <a href="kasirpenjualan.php">Kembali</a>
    </div>

</div>

<script>
// auto print saat halaman dibuka
window.onload = function() {
    window.print();
}
</script>

</body>
</html>