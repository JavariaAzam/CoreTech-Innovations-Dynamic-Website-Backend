<?php
declare(strict_types=1);
require_once __DIR__ . '/app_config.php';

function db(): PDO {
    static $pdo;
    if (!$pdo) {
        $pdo = new PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
            DB_USER, DB_PASS,
            [ PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC ]
        );
    }
    return $pdo;
}
