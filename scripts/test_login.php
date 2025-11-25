<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$creds = ['email' => 'testuser@example.com', 'password' => 'Password123'];

if (Auth::attempt($creds)) {
    echo "Login successful\n";
} else {
    echo "Login failed\n";
}
