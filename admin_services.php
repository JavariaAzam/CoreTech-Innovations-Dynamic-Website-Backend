<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_helpers.php';

$pdo = db();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  if (isset($_POST['add'])) {
    $title=trim($_POST['title']); $desc=trim($_POST['description']);
    $pdo->prepare('INSERT INTO services(title,description) VALUES(?,?)')->execute([$title,$desc]);
    flash('success','Service added.');
  } elseif (isset($_POST['update'])) {
    $id=(int)$_POST['id']; $t=trim($_POST['title']); $d=trim($_POST['description']);
    $pdo->prepare('UPDATE services SET title=?, description=? WHERE id=?')->execute([$t,$d,$id]);
    flash('success','Service updated.');
  } elseif (isset($_POST['delete'])) {
    $id=(int)$_POST['id']; $pdo->prepare('DELETE FROM services WHERE id=?')->execute([$id]);
    flash('success','Service deleted.');
  }
  redirect(ADMIN_URL.'/services.php');
}

$items = $pdo->query('SELECT * FROM services ORDER BY created_at DESC')->fetchAll();
include 'admin_layout_top.php'; render_flash();
?>
<h4>Services</h4>
<form method="post" class="card card-body mb-3">
  <?= csrf_field() ?><input type="hidden" name="add" value="1">
  <div class="mb-2"><input name="title" class="form-control" placeholder="Service title" required></div>
  <div class="mb-2"><textarea name="description" class="form-control" placeholder="Description" rows="3" required></textarea></div>
  <button class="btn btn-primary">Add</button>
</form>

<div class="list-group">
<?php foreach ($items as $it): ?>
  <form method="post" class="list-group-item">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?=$it['id']?>">
    <div class="row g-2 align-items-start">
      <div class="col-md-3"><input name="title" class="form-control" value="<?=h($it['title'])?>"></div>
      <div class="col-md-7"><textarea name="description" class="form-control" rows="2"><?=h($it['description'])?></textarea></div>
      <div class="col-md-2 text-end">
        <button name="update" value="1" class="btn btn-sm btn-secondary">Save</button>
        <button name="delete" value="1" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
      </div>
    </div>
  </form>
<?php endforeach; if(!$items): ?>
  <div class="list-group-item text-muted">No services yet.</div>
<?php endif; ?>
</div>
<?php include 'amin_layout_bottom.php'; ?>
