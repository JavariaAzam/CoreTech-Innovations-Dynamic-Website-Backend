<?php
declare(strict_types=1);
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="'.h(csrf_token()).'">';
}
function csrf_verify(): void {
    $ok = isset($_POST['csrf']) && hash_equals($_SESSION['csrf']??'', $_POST['csrf']);
    if (!$ok) { http_response_code(419); exit('CSRF failed'); }
}
