<?php
require_once __DIR__.'/../app_db.php';
header('Content-Type: application/json');
$rows = db()->query('SELECT title, description FROM services ORDER BY created_at DESC')->fetchAll();
echo json_encode($rows);
