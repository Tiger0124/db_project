<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$supabaseUrl = 'https://xlomzrhmzjjfjmsvqxdo.supabase.co';
$supabaseApiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo';

// 建立 Guzzle Client
$supabaseClient = new Client([
    'base_uri' => $supabaseUrl . '/rest/v1/',
    'headers' => [
        'apikey' => $supabaseApiKey,
        'Authorization' => 'Bearer ' . $supabaseApiKey,
        'Accept' => 'application/json',
    ],
    'verify' => false
    'verify' => false // 將此路徑替換為實際路徑
]);
?>
