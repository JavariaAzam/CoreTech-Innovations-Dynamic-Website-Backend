<?php
declare(strict_types=1);
session_start();

const DB_HOST = '127.0.0.1';
const DB_NAME = 'coretech_cms';
const DB_USER = 'root';
const DB_PASS = '';

const BASE_URL = '/CoreTech Innovations-Dynamic Website Backend';          // Adjust to your folder
const ADMIN_URL = BASE_URL . '/admin';
const UPLOAD_DIR = __DIR__ . '/../uploads';
const UPLOAD_URL = BASE_URL . '/uploads';

if (!is_dir(UPLOAD_DIR)) { @mkdir(UPLOAD_DIR, 0775, true); }
