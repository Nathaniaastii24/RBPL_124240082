<?php
$conn = new mysqli("localhost","root","","warung");

$data = $conn->query("
    SELECT 
        SUM(total) as total,
        COUNT(*) as transaksi
    FROM penjualan
")->fetch_assoc();
?>

<h2>Laporan Pendapatan</h2>

<p>Total Transaksi: <?= $data['transaksi'] ?></p>
<p>Total Pendapatan: Rp <?= number_format($data['total']) ?></p>