<?php
// serve-admin.php - Dành riêng cho Admin
$port = env('ADMIN_PORT', 8001);
echo "Admin Panel đang chạy tại http://127.0.0.1:{$port}\n";
passthru("php artisan serve --port={$port}");