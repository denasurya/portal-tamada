<?php

$baseUrl = 'http://localhost:8000';
$cookieJar = tempnam(sys_get_temp_dir(), 'cookies');

function httpGet($url, $cookieJar, $follow = true) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($follow) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $httpCode, 'response' => $response];
}

function httpPost($url, $data, $cookieJar, $follow = true) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($follow) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $httpCode, 'response' => $response];
}

echo "1. Get login page\n";
$res = httpGet($baseUrl . '/login', $cookieJar);
preg_match('/name="_token" value="([^"]+)"/', $res['response'], $matches);
$csrf = $matches[1] ?? '';

echo "2. Login as Admin\n";
$res = httpPost($baseUrl . '/login', [
    '_token' => $csrf,
    'username' => 'admin',
    'password' => 'admin123'
], $cookieJar, false);

echo "3. Access Admin Dashboard\n";
$res = httpGet($baseUrl . '/admin/dashboard', $cookieJar);
if ($res['code'] === 200 && strpos($res['response'], 'Selamat datang di Portal Admin') !== false) {
    echo "✅ Admin Dashboard OK\n";
} else {
    echo "❌ Admin Dashboard FAILED\n";
}

$endpoints = [
    '/admin/jurusan' => 'Master Jurusan',
    '/admin/rombel' => 'Master Rombel',
    '/admin/mapel' => 'Master Mata Pelajaran',
    '/admin/guru' => 'Master Guru',
    '/admin/siswa' => 'Master Siswa',
    '/admin/user' => 'User Management',
    '/admin/system/activity-log' => 'Aktivitas Sistem',
    '/admin/system/settings' => 'Pengaturan Sistem',
];

foreach ($endpoints as $path => $name) {
    $res = httpGet($baseUrl . $path, $cookieJar);
    if ($res['code'] === 200 && strpos($res['response'], $name) !== false) {
        echo "✅ {$name} OK\n";
    } else {
        echo "❌ {$name} FAILED (Code: {$res['code']})\n";
    }
}

unlink($cookieJar);
