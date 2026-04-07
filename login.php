<?php
session_start();

$roles = [
    ['name' => 'Pemilik',     'desc' => 'Akses penuh ke semua fitur',  'dashboard' => 'dashboardpemilik.php'],
    ['name' => 'Admin',       'desc' => 'Kelola data & laporan',        'dashboard' => 'admindashboard.php'],
    ['name' => 'Kasir',       'desc' => 'Transaksi & pembayaran',       'dashboard' => 'kasirdashboard.php'],
    ['name' => 'Pramuniaga',  'desc' => 'Pelayanan pelanggan',          'dashboard' => 'pramuniagadashboard.php'],
];

$selected_role = null;
$error = '';

if (isset($_POST['login'])) {
    $selected_role = htmlspecialchars($_POST['role']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // === Ganti logika ini dengan pengecekan ke database ===
    if ($username === 'admin' && $password === '1234') {
        $_SESSION['role'] = $selected_role;
        $_SESSION['username'] = $username;

        switch ($selected_role) {
            case 'Pemilik':
                header('Location: dashboardpemilik.php');
                exit;
            case 'Admin':
                header('Location: admindashboard.php');
                exit;
            case 'Kasir':
                header('Location: kasirdashboard.php');
                exit;
            case 'Pramuniaga':
                header('Location: pramuniagadashboard.php');
                exit;
            default:
                header('Location: index.php');
                exit;
        }
    } else {
        $error = 'Username atau password salah.';
        $selected_role = htmlspecialchars($_POST['role']);
    }

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
<body>

<?php if (!$selected_role): ?>
<!-- HALAMAN PILIH ROLE -->
<div class="container">
    <div class="title-section">
        <h1>PILIH SEBAGAI</h1>
        <div class="divider"></div>
        <p>Silakan tentukan peran Anda untuk melanjutkan ke sistem sesuai dengan hak akses yang telah ditetapkan.</p>
    </div>
    <div class="roles-list">
        <?php foreach ($roles as $role): ?>
        <form method="POST" action="">
            <button type="submit" name="choose_role" value="<?= $role['name'] ?>" class="role-btn">
                <div class="role-text">
                    <div class="role-name"><?= $role['name'] ?></div>
                    <div class="role-desc"><?= $role['desc'] ?></div>
                </div>
                <span class="role-arrow">→</span>
            </button>
        </form>
        <?php endforeach; ?>
    </div>
</div>

<?php else: ?>
<!-- HALAMAN LOGIN -->
<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#FFF8E1;">
    <div style="width:100%; max-width:420px; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
        
        <div style="background:#C8E6C9; padding:10px 16px; font-size:13px; color:#2E7D32; font-weight:500;">
            Role Selection
        </div>

        <div style="display:flex; flex-direction:column; align-items:center; gap:14px; padding:30px 40px 36px;">

            <div style="width:120px; height:120px; background:#e0e0e0; border-radius:12px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img src="asset/logohijau.png" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>

            <div style="font-size:15px; color:#1A1A1A; font-weight:500;">
                Masuk Sebagai <?= $selected_role ?>
            </div>

            <?php if ($error): ?>
                <div style="color:#c0392b; font-size:13px; text-align:center;"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="" style="width:100%; display:flex; flex-direction:column; align-items:center; gap:10px;">
                <input type="hidden" name="role" value="<?= $selected_role ?>">
                <input type="hidden" name="login" value="1">

                <input type="text" name="username" placeholder="Email" required
                    style="width:100%; padding:10px 14px; border:none; border-radius:8px; background:#e0e0e0; font-size:14px; color:#1A1A1A; outline:none;">

                <input type="password" name="password" placeholder="Password" required
                    style="width:100%; padding:10px 14px; border:none; border-radius:8px; background:#e0e0e0; font-size:14px; color:#1A1A1A; outline:none;">

                <button type="submit"
                    style="margin-top:10px; padding:10px 30px; background:#e0e0e0; border:none; border-radius:8px; font-size:14px; color:#1A1A1A; cursor:pointer;">
                    Masuk
                </button>
            </form>

            <form method="POST" action="">
                <button type="submit"
                    style="background:none; border:none; color:#4A4A4A; font-size:13px; cursor:pointer;">
                    Kembali
                </button>
            </form>

        </div>
    </div>
</div>
<?php endif; ?>

</body>
</html>