<?php
require_once 'conn.php';

// 檢查是否有提交刪除請求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $year = $_POST['year'] ?? '';
    
    try {
        $deleteSuccess = false;
        $errorMessage = '';
        
        // 只刪除指導老師資料
        try {
            $response = $supabaseClient->delete('指導老師', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            
            if ($statusCode === 204 || $statusCode === 200) {
                $deleteSuccess = true;
            } else {
                $errorMessage = "刪除指導老師資料失敗，HTTP 狀態碼：" . $statusCode;
            }
        } catch (Exception $e) {
            $errorMessage = "刪除指導老師時發生錯誤: " . $e->getMessage();
        }
        
        // 準備返回頁面的參數
        $redirectParams = [
            'username' => $username,
            'password' => $password,
            'year' => $year
        ];
        
        if ($deleteSuccess) {
            $redirectParams['delete_success'] = '1';
            $redirectParams['delete_message'] = '指導老師資料刪除成功！隊伍、學生和作品資料保持不變。';
        } else {
            $redirectParams['delete_error'] = $errorMessage;
        }
        
        // 重定向回教師檢視頁面
        echo '<form id="redirectForm" method="POST" action="view_teachers.php">';
        foreach ($redirectParams as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        
    } catch (Exception $e) {
        echo '<form id="redirectForm" method="POST" action="view_teachers.php">';
        echo '<input type="hidden" name="username" value="' . htmlspecialchars($username) . '">';
        echo '<input type="hidden" name="password" value="' . htmlspecialchars($password) . '">';
        echo '<input type="hidden" name="year" value="' . htmlspecialchars($year) . '">';
        echo '<input type="hidden" name="delete_error" value="刪除過程中發生未預期的錯誤: ' . htmlspecialchars($e->getMessage()) . '">';
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
    }
} else {
    // 如果沒有正確的請求，重定向到教師檢視頁面
    header('Location: view_teachers.php');
    exit;
}
?>
