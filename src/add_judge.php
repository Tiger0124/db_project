<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $session = $_POST['session'];
    $sessionNumber = str_replace(['第', '屆'], '', $session);//13
    try {
        // 先檢查是否已存在相同身分證字號和屆數的評審
        $checkResponse = $supabaseClient->get('評審委員', [
            'query' => [
                '身分證字號' => 'eq.' . $id_number,
                '屆數' => 'eq.' . $sessionNumber,
                'select' => '*',
            ]
        ]);
        
        $existingData = json_decode($checkResponse->getBody()->getContents(), true);
        
        if (!empty($existingData)) {
            echo "<script>
                alert('此評審委員在該屆數已存在！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 新增評審委員資料
        $response = $supabaseClient->post('評審委員', [
            'json' => [
                '身分證字號' => $id_number,
                '電子郵件' => $email,
                '頭銜' => $title,
                '姓名' => $name,
                '電話' => $phone,
                '密碼' => $password,
                '屆數' => $sessionNumber
            ]
        ]);

        if ($response->getStatusCode() === 201) {
            echo "<script>
                alert('評審委員新增成功！');
                window.location.href = 'view_judges.php';
            </script>";
        } else {
            echo "<script>
                alert('新增失敗，HTTP 狀態碼：" . $response->getStatusCode() . "');
                window.history.back();
            </script>";
        }
        
    } catch (Exception $e) {
        echo "<script>
            alert('新增失敗：" . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}
?>
