<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Str;

$email = 'testuser@example.com';
$username = 'testuser';
$exists = User::where('email', $email)->orWhere('username', $username)->first();
if ($exists) {
    echo "User already exists: {$exists->id}\n";
    exit;
}

$user = User::create([
    'name' => 'Test User',
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => $email,
    'username' => $username,
    'phone' => '0000000000',
    'password' => password_hash('Password123', PASSWORD_BCRYPT),
]);

echo "Created test user: id={$user->id}, email={$user->email}, username={$user->username}, password=Password123\n";
