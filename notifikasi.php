<?php
$conn = new mysqli("localhost","root","","warung");

$data = $conn->query("
    SELECT * FROM barang 
    WHERE stok <= 5
");
?>

<h2>Notifikasi Stok Menipis</h2>

<?php if($data->num_rows > 0): ?>
<ul>
<?php while($d = $data->fetch_assoc()): ?>
    <li><?= $d['nama'] ?> (stok: <?= $d['stok'] ?>)</li>
<?php endwhile; ?>
</ul>
<?php else: ?>
<p>Semua stok aman 👍</p>
<?php endif; ?>