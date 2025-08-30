<?php require_once __DIR__.'/../app_config.php'; ?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>CoreTech CMS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head><body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?=ADMIN_URL?>/dashboard.php">CoreTech CMS</a>
    <div>
      <a href="<?=ADMIN_URL?>/home.php" class="btn btn-sm btn-outline-light">Home</a>
      <a href="<?=ADMIN_URL?>/about.php" class="btn btn-sm btn-outline-light">About</a>
      <a href="<?=ADMIN_URL?>/services.php" class="btn btn-sm btn-outline-light">Services</a>
      <a href="<?=ADMIN_URL?>/team.php" class="btn btn-sm btn-outline-light">Team</a>
      <a href="<?=ADMIN_URL?>/portfolio.php" class="btn btn-sm btn-outline-light">Portfolio</a>
      <a href="<?=ADMIN_URL?>/messages.php" class="btn btn-sm btn-outline-light">Messages</a>
      <a href="<?=ADMIN_URL?>/profile.php" class="btn btn-sm btn-warning">Profile</a>
      <a href="<?=ADMIN_URL?>/logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
  </div>
</nav>
<div class="container py-4">
