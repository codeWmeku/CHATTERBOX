<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;

$updated = 0;
Post::whereNull('image')->chunk(100, function($posts) use (&$updated) {
    foreach ($posts as $p) {
        $p->image = 'https://picsum.photos/800/450?random=' . ($p->id + rand(1,100000));
        $p->save();
        $updated++;
    }
});

echo "Updated: $updated\n";
