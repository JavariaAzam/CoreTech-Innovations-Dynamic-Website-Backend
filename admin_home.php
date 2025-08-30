<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_upload.php';
require_once __DIR__.'/../app_helpers.php';

$pdo = db();

if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  if (isset($_POST['hero_title'])) {
    $title = trim($_POST['hero_title']); $tagline = trim($_POST['hero_tagline']);
    $pdo->prepare('UPDATE home_content SET hero_title=?, hero_tagline=? WHERE id=1')->execute([$title,$tagline]);
    flash('success','Hero updated.');
  } elseif (isset($_POST['add_slider'])) {
    try {
      $url = save_upload($_FILES['image']);
      if ($url) $pdo->prepare('INSERT INTO sliders(image_path) VALUES(?)')->execute([$url]);
      flash('success','Slider image added.');
    } catch (Throwable $e) { flash('error',$e->getMessage()); }
  } elseif (isset($_POST['delete_slider'])) {
    $id=(int)$_POST['id']; $pdo->prepare('DELETE FROM sliders WHERE id=?')->execute([$id]);
    flash('success','Slider image deleted.');
  }
  redirect(ADMIN_URL.'/home.php');
}

$hero = $pdo->query('SELECT * FROM home_content WHERE id=1')->fetch();
$slides = $pdo->query('SELECT * FROM sliders ORDER BY id DESC')->fetchAll();

include 'admin_layout_top.php'; render_flash();
?>
<h4>Home – Hero</h4>
<form method="post" class="card card-body mb-4">
  <?= csrf_field() ?>
  <div class="mb-3"><label class="form-label">Hero Title</label>
    <input name="hero_title" class="form-control" value="<?=h($hero['hero_title'] ?? '')?>" required></div>
  <div class="mb-3"><label class="form-label">Hero Tagline</label>
    <input name="hero_tagline" class="form-control" value="<?=h($hero['hero_tagline'] ?? '')?>" required></div>
  <button class="btn btn-primary">Save</button>
</form>

<h4>Slider Images</h4>
<form method="post" enctype="multipart/form-data" class="card card-body mb-3">
  <?= csrf_field() ?>
  <input type="hidden" name="add_slider" value="1">
  <div class="mb-3"><input type="file" name="image" accept="image/*" class="form-control" required></div>
  <button class="btn btn-success">Add Image</button>
</form>

<div class="row">
<?php foreach ($slides as $s): ?>
  <div class="col-md-3 mb-3">
    <div class="card">
      <img src="<?=$s['image_path']?>" class="card-img-top">
      <div class="card-body text-center">
        <form method="post" onsubmit="return confirm('Delete image?');">
          <?= csrf_field() ?>
          <input type="hidden" name="delete_slider" value="1">
          <input type="hidden" name="id" value="<?=$s['id']?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include 'admin_layout_bottom.php'; ?>
