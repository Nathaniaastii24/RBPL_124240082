<?php
// Role Selection Page
$roles = [
    ['name' => 'Pemilik', 'icon' => '👑', 'desc' => 'Akses penuh ke semua fitur'],
    ['name' => 'Admin', 'icon' => '🛡️', 'desc' => 'Kelola data & laporan'],
    ['name' => 'Kasir', 'icon' => '🧾', 'desc' => 'Transaksi & pembayaran'],
    ['name' => 'Pramuniaga', 'icon' => '🛍️', 'desc' => 'Pelayanan pelanggan'],
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

</head>
<body>
<div class="container">
    <div class="logo-wrap">
        <div class="logo-box"></div>
    </div>

    <div class="title-section">
        <h1>PILIH SEBAGAI</h1>
        <div class="divider"></div>
        <p>Silakan tentukan peran Anda untuk melanjutkan ke sistem sesuai dengan hak akses yang telah ditetapkan.</p>
    </div>

    <form method="POST" action="">
        <div class="roles-list">
            <?php foreach ($roles as $role): ?>
            <button type="submit" name="role" value="<?= htmlspecialchars($role['name']) ?>" class="role-btn">
                <div class="role-icon"><?= $role['icon'] ?></div>
                <div class="role-text">
                    <div class="role-name"><?= htmlspecialchars($role['name']) ?></div>
                    <div class="role-desc"><?= htmlspecialchars($role['desc']) ?></div>
                </div>
                <span class="role-arrow">→</span>
            </button>
            <?php endforeach; ?>
        </div>
    </form>
</div>
</body>
</html>