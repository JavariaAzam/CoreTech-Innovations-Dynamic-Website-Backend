<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';

$pdo = db();
$me = current_user();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  $old = $_POST['old']??''; $new = $_POST['new']??'';
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id=?'); $stmt->execute([$me['id']]); $u=$stmt->fetch();
  if ($u && password_verify($old, $u['password_hash'])) {
    $hash = password_hash($new, PASSWORD_DEFAULT);
    $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([$hash,$me['id']]);
    flash('success','Password updated.');
  } else { flash('error','Old password incorrect.'); }
  redirect(ADMIN_URL.'/profile.php');
}
include 'admin_layout_top.php'; render_flash();
?>
<h4>Profile</h4>
<form method="post" class="card card-body" style="max-width:480px">
  <?= csrf_field() ?>
  <div class="mb-3"><label class="form-label">Old Password</label><input type="password" name="old" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new" class="form-control" minlength="8" required></div>
  <button class="btn btn-primary">Change Password</button>
</form>
<?php include 'admin_layout_bottom.php'; ?>
