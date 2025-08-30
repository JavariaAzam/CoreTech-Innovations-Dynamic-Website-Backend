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
    $title=trim($_POST['title']); $desc=trim($_POST['description']);
    try {
      $url = save_upload($_FILES['image']);
      if (!$url) throw new RuntimeException('Image required');
      $pdo->prepare('INSERT INTO portfolio(title,description,image_path) VALUES(?,?,?)')->execute([$title,$desc,$url]);
      flash('success','Project added.');
    } catch (Throwable $e) { flash('error',$e->getMessage()); }
  } elseif (isset($_POST['delete'])) {
    $id=(int)$_POST['id']; $pdo->prepare('DELETE FROM portfolio WHERE id=?')->execute([$id]);
    flash('success','Deleted.');
  }
  redirect(ADMIN_URL.'/portfolio.php');
}

$projects = $pdo->query('SELECT * FROM portfolio ORDER BY created_at DESC')->fetchAll();
include 'admin_layout_top.php'; render_flash();
?>
<h4>Portfolio</h4>
<form method="post" enctype="multipart/form-data" class="card card-body mb-3">
  <?= csrf_field() ?><input type="hidden" name="add" value="1">
  <div class="row g-2">
    <div class="col-md-4"><input name="title" class="form-control" placeholder="Title" required></div>
    <div class="col-md-5"><input type="file" name="image" accept="image/*" class="form-control" required></div>
    <div class="col-md-3"><button class="btn btn-primary w-100">Add</button></div>
  </div>
  <div class="mt-2"><textarea name="description" class="form-control" rows="3" placeholder="Description"></textarea></div>
</form>

<div class="row">
<?php foreach ($projects as $p): ?>
  <div class="col-md-4 mb-3">
    <div class="card h-100">
      <img src="<?=$p['image_path']?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?=h($p['title'])?></h5>
        <p class="card-text"><?=h($p['description'])?></p>
      </div>
      <div class="card-footer text-end">
        <form method="post" onsubmit="return confirm('Delete project?');">
          <?= csrf_field() ?><input type="hidden" name="delete" value="1"><input type="hidden" name="id" value="<?=$p['id']?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include 'admin_layout_bottom.php'; ?>
