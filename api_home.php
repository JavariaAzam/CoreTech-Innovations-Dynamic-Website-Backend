<?php
require_once __DIR__.'/../app_db.php';
header('Content-Type: application/json');
$pdo = db();
$hero = $pdo->query('SELECT hero_title, hero_tagline FROM home_content WHERE id=1')->fetch();
$slides = $pdo->query('SELECT image_path FROM sliders ORDER BY id DESC')->fetchAll();
echo json_encode(['hero'=>$hero, 'sliders'=>$slides]);
