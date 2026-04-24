<?php
// Role Selection Page
$roles = [
    ['name' => 'Pemilik', 'icon' => '', 'desc' => 'Akses penuh ke semua fitur'],
    ['name' => 'Admin', 'icon' => '', 'desc' => 'Kelola data & laporan'],
    ['name' => 'Kasir', 'icon' => '', 'desc' => 'Transaksi & pembayaran'],
    ['name' => 'Pramuniaga', 'icon' => '', 'desc' => 'Pelayanan pelanggan'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role'])) {
    $selected = htmlspecialchars($_POST['role']);
    // Simpan ke session atau proses sesuai kebutuhan
    // session_start();
    // $_SESSION['role'] = $selected;
    // header('Location: dashboard.php');
    // exit;
    echo "<script>alert('Anda masuk sebagai: $selected'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color:#FFF8E1;">

<div class="container" style="max-width:420px; margin:60px auto;">
     <!-- LOGO -->
<div style="width:160px; height:160px; background:#e0e0e0; border-radius:16px; display:flex; align-items:center; justify-content:center; overflow:hidden; margin:0 auto 28px auto;">
    <img src="asset/logohijau.png" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
</div>
    <div class="title-section">
        <h1>PILIH SEBAGAI</h1>
        <div class="divider"></div>
        <p>Silakan tentukan peran Anda untuk melanjutkan ke sistem sesuai dengan hak akses yang telah ditetapkan.</p>
    </div>

    <div class="roles-list">
        <button onclick="window.location.href='loginpemilik.php'" class="role-btn">
            <div class="role-text">
                <div class="role-name">Pemilik</div>
                <div class="role-desc">Akses penuh ke semua fitur</div>
            </div>
            <span class="role-arrow"></span>
        </button>

        <button onclick="window.location.href='loginadmin.php'" class="role-btn">
            <div class="role-text">
                <div class="role-name">Admin</div>
                <div class="role-desc">Kelola data & laoran</div>
            </div>
            <span class="role-arrow"></span>
        </button>

        <button onclick="window.location.href='loginkasir.php'" class="role-btn">
            <div class="role-text">
                <div class="role-name">Kasir</div>
                <div class="role-desc">Transaksi & pembayaran</div>
            </div>
            <span class="role-arrow"></span>
        </button>

        <button onclick="window.location.href='loginpramuniaga.php'" class="role-btn">
            <div class="role-text">
                <div class="role-name">Pramuniaga</div>
                <div class="role-desc">Pelayanan pelanggan</div>
            </div>
        </button>
    </div>
</div>

</body>
</html>