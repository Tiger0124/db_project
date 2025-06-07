<?php
require_once 'conn.php';

// 檢查是否有提交刪除請求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_number']) && isset($_POST['session'])) {
    $id_number = $_POST['id_number'];
    $session = $_POST['session'];
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $year = $_POST['year'] ?? '';
    
    try {
        $deleteSuccess = false;
        $errorMessage = '';
        
        // 刪除評審委員資料
        try {
            $response = $supabaseClient->delete('評審委員', [
                'query' => [
                    '身分證字號' => 'eq.' . $id_number,
                    '屆數' => 'eq.' . $session
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            
            if ($statusCode === 204 || $statusCode === 200) {
                $deleteSuccess = true;
            } else {
                $errorMessage = "刪除評審委員資料失敗，HTTP 狀態碼：" . $statusCode;
            }
        } catch (Exception $e) {
            $errorMessage = "刪除評審委員時發生錯誤: " . $e->getMessage();
        }
        
        // 準備返回頁面的參數
        $redirectParams = [
            'username' => $username,
            'password' => $password,
            'year' => $year
        ];
        
        if ($deleteSuccess) {
            $redirectParams['delete_success'] = '1';
        } else {
            $redirectParams['delete_error'] = $errorMessage;
        }
        
        // 重定向回評審檢視頁面
        echo '<form id="redirectForm" method="POST" action="view_judges.php">';
        foreach ($redirectParams as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        
    } catch (Exception $e) {
        echo '<form id="redirectForm" method="POST" action="view_judges.php">';
        echo '<input type="hidden" name="username" value="' . htmlspecialchars($username) . '">';
        echo '<input type="hidden" name="password" value="' . htmlspecialchars($password) . '">';
        echo '<input type="hidden" name="year" value="' . htmlspecialchars($year) . '">';
        echo '<input type="hidden" name="delete_error" value="刪除過程中發生未預期的錯誤: ' . htmlspecialchars($e->getMessage()) . '">';
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
    }
} else {
    // 如果沒有正確的請求，重定向到評審檢視頁面
    header('Location: view_judges.php');
    exit;
}
?>
