<?php
$conn = new mysqli("localhost","root","","warung");

$data = $conn->query("SELECT * FROM barang");
?>

<h2>Laporan Stok Barang</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Nama Barang</th>
    <th>Stok</th>
</tr>

<?php while($d = $data->fetch_assoc()): ?>
<tr>
    <td><?= $d['nama'] ?></td>
    <td><?= $d['stok'] ?></td>
</tr>
<?php endwhile; ?>
</table>