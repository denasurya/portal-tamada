<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$mapels = App\Models\MataPelajaran::pluck('nama')->toArray();
echo "Mapel: " . implode(', ', $mapels) . "\n";
