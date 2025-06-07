<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_id = $_POST['original_id'];
    $original_session = $_POST['original_session'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $session = $_POST['session'];
    $sessionNumber = str_replace(['第', '屆'], '', $session);//13
    try {
        // 如果身分證字號或屆數有變更，需要檢查是否與其他記錄衝突
        if ($original_id !== $id_number || $original_session !== $session) {
            $checkResponse = $supabaseClient->get('評審委員', [
                'query' => [
                    '身分證字號' => 'eq.' . $id_number,
                    '屆數' => 'eq.' . $session,
                    'select' => '*',
                ]
            ]);
            
            $existingData = json_decode($checkResponse->getBody()->getContents(), true);
            
            if (!empty($existingData)) {
                echo "<script>
                    alert('此身分證字號在該屆數已存在其他評審委員！');
                    window.history.back();
                </script>";
                exit;
            }
        }
        
        // 更新評審委員資料
        $response = $supabaseClient->patch('評審委員', [
            'query' => [
                '身分證字號' => 'eq.' . $original_id,
                '屆數' => 'eq.' . $original_session
            ],
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

        // if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
            echo "<script>
                alert('評審委員資料更新成功！');
                window.location.href = 'view_judges.php';
            </script>";
        // } else {
        //     echo "<script>
        //         alert('更新失敗，HTTP 狀態碼：" . $response->getStatusCode() . "');
        //         window.history.back();
        //     </script>";
        // }
        
    } catch (Exception $e) {
        echo "<script>
            alert('更新失敗：" . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}
?>
