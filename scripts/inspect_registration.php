<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Route;
use App\Models\User;

$hasSignup = false;
foreach (Route::getRoutes() as $r) {
    if (in_array('signup', (array) $r->getName())) { $hasSignup = true; break; }
    if ($r->uri() === 'signup') { $hasSignup = true; break; }
}

echo "Signup route registered: " . ($hasSignup ? 'yes' : 'no') . "\n\n";

echo "Signup form path: resources/views/auth/signin.blade.php (use ?mode=signup to show)\n";
echo "Signup POST action: route('signup') -> POST /signup\n\n";

// Print last 8 users
$users = User::orderBy('id', 'desc')->take(8)->get();
if ($users->count()) {
    echo "Most recent users (id, username, email, created_at):\n";
    foreach ($users as $u) {
        printf("%d\t%s\t%s\t%s\n", $u->id, $u->username ?? '-', $u->email ?? '-', $u->created_at);
    }
} else {
    echo "No users in DB.\n";
}
