<?php
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$usability = \App\Models\Usability::first();
if ($usability) {
    $usability->youtube_url = 'https://youtu.be/uho6iGrApyQ?si=q0Lyj9rx-QivRZeG';
    $usability->save();
    echo "Successfully reverted database youtube_url back to its original value!\n";
} else {
    echo "No usability record found.\n";
}
