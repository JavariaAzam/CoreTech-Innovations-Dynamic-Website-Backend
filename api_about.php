<?php
require_once __DIR__.'/../app_db.php';
header('Content-Type: application/json');
$pdo = db();
$about = $pdo->query('SELECT mission, vision FROM about_content WHERE id=1')->fetch();
$team = $pdo->query('SELECT name, role, photo_path FROM team ORDER BY created_at DESC')->fetchAll();
echo json_encode(['about'=>$about, 'team'=>$team]);
