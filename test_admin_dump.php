<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$baseUrl = 'http://localhost:8000';
$cookieJar = 'test_cookies_2.txt';

$ch = curl_init($baseUrl . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$res = curl_exec($ch);

preg_match('/name="_token" value="([^"]+)"/', $res, $matches);
$csrf = $matches[1] ?? '';

curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrf,
    'username' => 'admin',
    'password' => 'admin123'
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $baseUrl . '/admin/dashboard');
curl_setopt($ch, CURLOPT_POST, false);
$res = curl_exec($ch);

echo "Admin Dashboard HTML Length: " . strlen($res) . "\n";
echo "First 500 chars:\n" . substr($res, 0, 500) . "\n";
