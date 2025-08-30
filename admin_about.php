w<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_helpers.php';

$pdo = db();
if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  $mission = trim($_POST['mission']??'');
  $vision  = trim($_POST['vision']??'');
  $pdo->prepare('UPDATE about_content SET mission=?, vision=? WHERE id=1')->execute([$mission,$vision]);
  flash('success','About updated.');
  redirect(ADMIN_URL.'/about.php');
}
$about = $pdo->query('SELECT * FROM about_content WHERE id=1')->fetch();
include 'admin_layout_top.php'; render_flash();
?>
<h4>About – Mission & Vision</h4>
<form method="post" class="card card-body">
  <?= csrf_field() ?>
  <div class="mb-3"><label class="form-label">Mission</label>
    <textarea name="mission" rows="4" class="form-control" required><?=h($about['mission']??'')?></textarea></div>
  <div class="mb-3"><label class="form-label">Vision</label>
    <textarea name="vision" rows="4" class="form-control" required><?=h($about['vision']??'')?></textarea></div>
  <button class="btn btn-primary">Save</button>
</form>
<?php include 'admin_layout_bottom.php'; ?>
