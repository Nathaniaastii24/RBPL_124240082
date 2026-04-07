<div class="sidebar">
    <div>
        <h2>Warung<br>Mbak Eni</h2>
        <div class="profile">
            <div class="avatar"></div>
            <div>Nama Akun<br><strong><?= $_SESSION['username'] ?? 'Admin' ?></strong></div>
        </div>
        <div class="menu">
            <a href="admindashboard.php"        <?= basename($_SERVER['PHP_SELF']) == 'admindashboard.php'        ? 'class="active"' : '' ?>>Dashboard</a>
            <a href="admin_kelola_barang.php"   <?= basename($_SERVER['PHP_SELF']) == 'admin_kelola_barang.php'   ? 'class="active"' : '' ?>>Kelola Barang</a>
            <a href="admin_penerimaan.php"      <?= basename($_SERVER['PHP_SELF']) == 'admin_penerimaan.php'      ? 'class="active"' : '' ?>>Input Penerimaan</a>
            <a href="admin_purchase_order.php"  <?= basename($_SERVER['PHP_SELF']) == 'admin_purchase_order.php'  ? 'class="active"' : '' ?>>Purchase Order</a>
            <a href="admin_laporan.php"         <?= basename($_SERVER['PHP_SELF']) == 'admin_laporan.php'         ? 'class="active"' : '' ?>>Laporan</a>
        </div>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>