<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Foundation\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Support\Str;

$dir = __DIR__ . '/../public/images/posts';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$updated = 0;
$downloaded = 0;
$skipped = 0;

$posts = Post::all();
foreach ($posts as $post) {
    $img = $post->image;
    if (!$img) { $skipped++; continue; }

    // If already local path (does not start with http(s) ) skip
    if (!preg_match('#^https?://#i', $img)) {
        $skipped++;
        continue;
    }

    // Build filename
    $ext = pathinfo(parse_url($img, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!$ext) $ext = 'jpg';
    $filename = 'post-' . $post->id . '-' . Str::random(6) . '.' . $ext;
    $localPath = 'images/posts/' . $filename;
    $fullPath = __DIR__ . '/../public/' . $localPath;

    // Download remote image
    try {
        $ctx = stream_context_create(['http' => ['timeout' => 10]]);
        $data = @file_get_contents($img, false, $ctx);
        if ($data === false) {
            echo "Failed to download image for post {$post->id}: {$img}\n";
            continue;
        }
        file_put_contents($fullPath, $data);
        // Update DB to point to local asset path
        $post->image = $localPath;
        $post->save();
        $downloaded++;
        $updated++;
        echo "Cached post {$post->id} -> {$localPath}\n";
    } catch (Exception $e) {
        echo "Error for post {$post->id}: " . $e->getMessage() . "\n";
    }
}

echo "Done. Downloaded: {$downloaded}, Updated: {$updated}, Skipped: {$skipped}\n";
