<?php
include 'conn.php';

if (!isset($_GET['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing name']);
    exit;
}

$name = $_GET['name'];
$response = $supabaseClient->get("指導老師?姓名=eq." . urlencode($name));
$data = json_decode($response->getBody(), true);

if (empty($data)) {
    echo json_encode(['email' => '', 'phone' => '']);
    exit;
}

$professor = $data[0]; // 預設只取第一筆
echo json_encode([
    'email' => $professor['電子郵件'] ?? '',
    'phone' => $professor['電話'] ?? ''
]);
