<?php
declare(strict_types=1);
require_once __DIR__.'/app_config.php';

function save_upload(array $file, array $allowed=['image/jpeg','image/png','image/webp'], int $maxBytes=2_000_000): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > $maxBytes) throw new RuntimeException('File too large');
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, $allowed, true)) throw new RuntimeException('Invalid file type');
    $ext = match ($mime) {
        'image/jpeg' => '.jpg',
        'image/png'  => '.png',
        'image/webp' => '.webp',
        default      => ''
    };
    $name = bin2hex(random_bytes(8)).$ext;
    $dest = UPLOAD_DIR . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) throw new RuntimeException('Upload failed');
    return UPLOAD_URL . '/' . $name;
}
