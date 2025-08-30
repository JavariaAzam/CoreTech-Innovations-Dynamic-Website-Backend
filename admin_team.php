<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_helpers.php';
require_once __DIR__.'/../app_upload.php';

$pdo = db();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  if (isset($_POST['add'])) {
    $name=trim($_POST['name']); $role=trim($_POST['role']);
    $photo=null; try { $photo = save_upload($_FILES['photo']); } catch(Throwable) {}
    $pdo->prepare('INSERT INTO team(name,role,photo_path) VALUES(?,?,?)')->execute([$name,$role,$photo]);
    flash('success','Team member added.');
  } elseif (isset($_POST['delete'])) {
    $id=(int)$_POST['id']; $pdo->prepare('DELETE FROM team WHERE id=?')->execute([$id]);
    flash('success','Deleted.');
  }
  redirect(ADMIN_URL.'/team.php');
}

$members = $pdo->query('SELECT * FROM team ORDER BY created_at DESC')->fetchAll();
include 'admin_layout_top.php'; render_flash();
?>
<h4>Team</h4>
<form method="post" enctype="multipart/form-data" class="card card-body mb-3">
  <?= csrf_field() ?>
  <input type="hidden" name="add" value="1">
  <div class="row g-3">
    <div class="col-md-4"><input name="name" class="form-control" placeholder="Name" required></div>
    <div class="col-md-4"><input name="role" class="form-control" placeholder="Role" required></div>
    <div class="col-md-4"><input type="file" name="photo" accept="image/*" class="form-control"></div>
  </div>
  <button class="btn btn-primary mt-3">Add</button>
</form>

<div class="row">
<?php foreach ($members as $m): ?>
  <div class="col-md-4 mb-3">
    <div class="card h-100">
      <?php if ($m['photo_path']): ?><img src="<?=$m['photo_path']?>" class="card-img-top"><?php endif; ?>
      <div class="card-body">
        <h5 class="card-title"><?=h($m['name'])?></h5>
        <p class="card-text text-muted"><?=h($m['role'])?></p>
      </div>
      <div class="card-footer text-end">
        <form method="post" onsubmit="return confirm('Delete member?');">
          <?= csrf_field() ?><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="<?=$m['id']?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include 'admin_layout_bottom.php'; ?>
