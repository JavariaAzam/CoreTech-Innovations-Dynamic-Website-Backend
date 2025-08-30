<?php
require_once __DIR__.'/../app_config.php';
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_auth.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  $u = trim($_POST['username']??''); $p = $_POST['password']??'';
  $stmt = db()->prepare('SELECT * FROM users WHERE username=?'); $stmt->execute([$u]);
  $row = $stmt->fetch();
  if ($row && password_verify($p, $row['password_hash'])) {
      login_user($row); flash('success','Welcome, '.$row['username'].'!');
      redirect(ADMIN_URL.'/dashboard.php');
  }
  flash('error','Invalid credentials.');
  redirect(ADMIN_URL.'/login.php');
}
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head><body class="bg-light">
<div class="container" style="max-width:460px">
  <h3 class="mt-5 mb-3 text-center">CoreTech CMS – Login</h3>
  <?php require_once __DIR__.'/../app/flash.php'; render_flash(); ?>
  <form method="post" class="card card-body">
    <?= csrf_field() ?>
    <div class="mb-3"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
    <button class="btn btn-primary w-100">Login</button>
  </form>
</div>
</body></html>
