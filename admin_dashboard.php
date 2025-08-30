<?php require_once __DIR__.'/../app_auth.php'; require_admin(); include 'admin_layout_top.php'; ?>
<?php require_once __DIR__.'/../app_flash.php'; render_flash(); ?>
<div class="row g-3">
  <div class="col-md-3"><a class="card card-body text-center" href="home.php">Home</a></div>
  <div class="col-md-3"><a class="card card-body text-center" href="about.php">About</a></div>
  <div class="col-md-3"><a class="card card-body text-center" href="services.php">Services</a></div>
  <div class="col-md-3"><a class="card card-body text-center" href="team.php">Team</a></div>
  <div class="col-md-3"><a class="card card-body text-center" href="portfolio.php">Portfolio</a></div>
  <div class="col-md-3"><a class="card card-body text-center" href="messages.php">Messages</a></div>
</div>
<?php include 'admin_layout_bottom.php'; ?>
