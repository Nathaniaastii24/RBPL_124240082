<?php
session_start();

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'pemilik') {
    header("Location: login.php");
    exit;
}


$conn = new mysqli("localhost", "root", "", "warung");

// ================== FILTER ==================
$awal  = $_GET['awal'] ?? date('Y-m-01');
$akhir = $_GET['akhir'] ?? date('Y-m-d');
$jenis = $_GET['jenis'] ?? '';

// ================== QUERY ==================
$query = "
SELECT * FROM penerimaan
WHERE DATE(tanggal) BETWEEN '$awal' AND '$akhir'
";

if ($jenis != '') {
    $query .= " AND jenis = '$jenis'";
}

$query .= " ORDER BY tanggal DESC";

$penerimaan = $conn->query($query);

?>

<!DOCTYPE html>
<html>
<head>
<title>Penerimaan Barang (Pemilik)</title>

<style>

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
.menu a.active {
    background: #C8E6C9;
    color: #1A1A1A;
    font-weight: bold;
}

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

.table{
    width:100%;
    border-collapse:collapse;
}

.table th, .table td{
    padding:10px;
    border-bottom:1px solid #eee;
    text-align:left;
}

.btn{
    padding:8px 15px;
    background:#2E7D32;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.filter{
    margin-bottom:10px;
}
.detail{
    background:#fafafa;
    padding:10px;
    margin-top:10px;
    border-radius:8px;
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
            <a href="pemilikpenerimaan.php" class="active">Penerimaan</a>
            <a href="pemiliksupplier.php">Supplier</a>
        </div>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

<h2>Monitoring Penerimaan Barang</h2>

<!-- FILTER -->
<div class="card">
    <form method="GET" class="filter">
        Dari: 
        <input type="date" name="awal" value="<?= $awal ?>">

        Sampai: 
        <input type="date" name="akhir" value="<?= $akhir ?>">

        Jenis:
        <select name="jenis">
            <option value="">Semua</option>
            <option value="Sayuran" <?= ($jenis=='Sayuran')?'selected':'' ?>>Sayuran</option>
            <option value="Sembako" <?= ($jenis=='Sembako')?'selected':'' ?>>Sembako</option>
        </select>

        <button class="btn">Filter</button>
    </form>
</div>

<!-- DATA -->
<div class="card">
    <h3>Data Penerimaan</h3>

    <table class="table">
        <tr>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Jenis</th>
            <th>Invoice</th>
            <th>Total</th>
            <th>Detail</th>
        </tr>

        <?php while($p = $penerimaan->fetch_assoc()): ?>
        <tr>
            <td><?= $p['tanggal'] ?></td>
            <td><?= $p['supplier'] ?></td>
            <td><?= $p['jenis'] ?></td>
            <td><?= $p['invoice'] ?></td>
            <td>Rp <?= number_format($p['total']) ?></td>
            <td>
                <button onclick="toggleDetail(<?= $p['id'] ?>)">Lihat</button>
            </td>
        </tr>

        <!-- DETAIL BARANG -->
        <tr id="detail<?= $p['id'] ?>" style="display:none;">
            <td colspan="6">
                <div class="detail">

                <b>Detail Barang:</b><br>

                <?php
                $detail = $conn->query("
                    SELECT d.*, b.nama 
                    FROM detail_penerimaan d
                    JOIN barang b ON d.barang_id = b.id
                    WHERE d.penerimaan_id = ".$p['id']
                );

                while($d = $detail->fetch_assoc()):
                ?>
                    <?= $d['nama'] ?> 
                    (<?= $d['jumlah'] ?> x <?= number_format($d['harga']) ?>)
                    = Rp <?= number_format($d['subtotal']) ?><br>
                <?php endwhile; ?>

                </div>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</div>

<script>
function toggleDetail(id){
    let el = document.getElementById("detail"+id);
    el.style.display = (el.style.display === "none") ? "table-row" : "none";
}
</script>

</body>
</html>