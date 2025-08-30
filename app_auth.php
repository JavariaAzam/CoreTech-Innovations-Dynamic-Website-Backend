<?php
declare(strict_types=1);
require_once __DIR__.'/app_db.php';
require_once __DIR__.'/app_helpers.php';
require_once __DIR__.'/app_flash.php';

function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_admin(): void { if (!current_user()) redirect(ADMIN_URL.'/login.php'); }
function login_user(array $u): void { session_regenerate_id(true); $_SESSION['user']=['id'=>$u['id'],'username'=>$u['username']]; }
function logout_user(): void { $_SESSION=[]; session_destroy(); }
