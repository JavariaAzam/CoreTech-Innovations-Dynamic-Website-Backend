<?php
require_once __DIR__.'/../app_config.php';
require_once __DIR__.'/../app_auth.php';
require_once __DIR__.'/../app_flash.php';
logout_user(); flash('info','Logged out.'); redirect(ADMIN_URL.'/login.php');
