<?php
require_once __DIR__.'/../app_auth.php'; require_admin();
require_once __DIR__.'/../app_db.php';
require_once __DIR__.'/../app_csrf.php';
require_once __DIR__.'/../app_flash.php';
require_once __DIR__.'/../app_helpers.php';

$pdo = db();
if ($_SERVER['REQUEST_METHOD']==='POST') {
  csrf_verify();
  if (isset($_POST['delete'])) {
    $id=(int)$_POST['id']; $pdo->prepare('DELETE FROM messages WHERE id=?')->execute([$id]);
    flash('success','Message deleted.');
    redirect(ADMIN_URL.'/messages.php');
  }
}
$messages = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();
include 'admin_layout_top.php'; render_flash();
?>
<h4>Contact Messages</h4>
<div class="table-responsive">
<table class="table table-striped">
  <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Received</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($messages as $m): ?>
    <tr>
      <td><?=h($m['name'])?></td>
      <td><?=h($m['email'])?></td>
      <td><?=h($m['subject'])?></td>
      <td style="max-width:360px"><?=h($m['message'])?></td>
      <td><?=h($m['created_at'])?></td>
      <td class="text-end">
        <form method="post" onsubmit="return confirm('Delete message?');">
          <?= csrf_field() ?><input type="hidden" name="delete" value="1">
          <input type="hidden" name="id" value="<?=$m['id']?>">
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
  <?php endforeach; if(!$messages): ?>
    <tr><td colspan="6" class="text-center text-muted">No messages yet.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
</div>
<?php include 'admin_layout_bottom.php'; ?>
