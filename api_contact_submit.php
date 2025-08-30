<?php
require_once __DIR__.'/../app_db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD']!=='POST') { http_response_code(405); echo json_encode(['error'=>'POST only']); exit; }

$name=trim($_POST['name']??''); $email=trim($_POST['email']??'');
$subject=trim($_POST['subject']??''); $message=trim($_POST['message']??'');

if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || $message==='') {
  http_response_code(422); echo json_encode(['error'=>'Invalid input']); exit;
}
$stmt = db()->prepare('INSERT INTO messages(name,email,subject,message) VALUES(?,?,?,?)');
$stmt->execute([$name,$email,$subject,$message]);
echo json_encode(['ok'=>true]);
