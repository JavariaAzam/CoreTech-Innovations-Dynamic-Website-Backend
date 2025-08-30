<?php
declare(strict_types=1);
function flash(string $k, ?string $v=null): ?string {
    if ($v!==null) { $_SESSION['flash'][$k]=$v; return null; }
    $m = $_SESSION['flash'][$k] ?? null;
    unset($_SESSION['flash'][$k]); return $m;
}
function render_flash(): void {
    foreach (['success'=>'success','error'=>'danger','info'=>'info'] as $k=>$cls) {
        if ($m = flash($k)) echo '<div class="alert alert-'.$cls.'">'.$m.'</div>';
    }
}
