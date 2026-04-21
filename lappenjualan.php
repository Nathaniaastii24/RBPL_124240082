<?php
$conn = new mysqli("localhost","root","","warung");

$data = $conn->query("
    SELECT * FROM penjualan 
    ORDER BY tanggal DESC
");
?>

<h2>Laporan Penjualan</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Metode</th>
</tr>

<?php while($d = $data->fetch_assoc()): ?>
<tr>
    <td><?= $d['tanggal'] ?></td>
    <td>Rp <?= number_format($d['total']) ?></td>
    <td><?= $d['metode'] ?></td>
</tr>
<?php endwhile; ?>
</table>