<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

$data = [
    'first_name' => 'Sim',
    'last_name' => 'Tester',
    'name' => null,
    'email' => 'simtester+' . rand(1000,9999) . '@example.com',
    'username' => 'simtester' . rand(1000,9999),
    'phone' => '1234567890',
    'password' => 'Password123',
    'password_confirmation' => 'Password123',
];

$request = Request::create('/signup', 'POST', $data);
$controller = new AuthController();
try {
    $response = $controller->signup($request);
    echo "Controller response: ";
    if (is_string($response)) echo $response . "\n";
    elseif (method_exists($response, 'getStatusCode')) echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
    else var_export($response);
} catch (Exception $e) {
    echo "Exception: " . get_class($e) . " - " . $e->getMessage() . "\n";
    // If validation exception, show messages
    if ($e instanceof Illuminate\Validation\ValidationException) {
        print_r($e->validator->errors()->toArray());
    }
}
