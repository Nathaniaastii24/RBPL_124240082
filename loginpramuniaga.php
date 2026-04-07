<?php
session_start();
if (isset($_SESSION['role'])) {
    header('Location: pramuniagadashboard.php'); exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $conn = new mysqli('localhost', 'root', '', 'warung');
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
if ($user && $password === $user['password']) {
    $_SESSION['role']     = 'Pramuniaga';
    $_SESSION['username'] = $user['email'];
    $_SESSION['id']       = $user['id'];
    header('Location: pramuniagadashboard.php'); exit;
} else {
    $error = 'Email atau password salah.';
}
    $stmt->close(); $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pramuniaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container" style="max-width:420px; margin:60px auto; background:#fff; border-radius:16px; padding:30px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
    <div style="width:160px; height:160px; background:#e0e0e0; border-radius:16px; display:flex; align-items:center; justify-content:center; overflow:hidden; margin:0 auto 28px auto;">
        <img src="asset/logohijau.png" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
    </div>
    <div class="title-section">
        <h1>Masuk Sebagai Pramuniaga</h1>
        <div class="divider"></div>
    </div>
    <form method="POST" action="">
        <div class="mb-3" style="max-width:300px; margin:0 auto;">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
        </div>
        <div class="mb-3" style="max-width:300px; margin:0 auto;">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <?php if ($error): ?>
            <p style="color:red; text-align:center; font-size:13px;"><?= $error ?></p>
        <?php endif; ?>
        <div style="text-align:center; margin-top:10px;">
            <button class="btn" type="submit" style="background-color:#2E7D32; color:#fff; border:none;">Masuk</button>
        </div>
    </form>
    <div style="text-align:center; margin-top:12px;">
        <a href="index.php" style="font-size:13px; color:#4A4A4A; text-decoration:none;">← Kembali</a>
    </div>
</div>
</body>
</html>