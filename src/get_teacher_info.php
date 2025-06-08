<?php include 'darkmode.php'; ?>
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
    echo json_encode(['email' => '', 'phone' => '', 'jobtitle' => '', 'id' => '']);
    exit;
}

// 轉成只回 email / phone
$infoList = array_map(function ($professor) {
    return [
        'email' => $professor['電子郵件'] ?? '',
        'phone' => $professor['電話'] ?? '',
        'jobtitle' => $professor['職稱'] ?? '',
        'id' => $professor['身分證字號'] ?? ''
    ];
}, $data);

echo json_encode($infoList);
