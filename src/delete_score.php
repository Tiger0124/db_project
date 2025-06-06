<?php
require_once 'conn.php';

// 檢查是否有提交刪除請求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['team_id'])) {
    $team_id = $_POST['team_id'];
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $year = $_POST['year'] ?? '';
    
    try {
        $deleteSuccess = true;
        $errorMessages = [];
        
        // 1. 刪除評分資料
        try {
            $response = $supabaseClient->delete('評分資料', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            if ($response->getStatusCode() !== 204 && $response->getStatusCode() !== 200) {
                $errorMessages[] = "刪除評分資料失敗";
                $deleteSuccess = false;
            }
        } catch (Exception $e) {
            $errorMessages[] = "刪除評分資料時發生錯誤: " . $e->getMessage();
            $deleteSuccess = false;
        }
        
        // 2. 刪除作品資料
        try {
            $response = $supabaseClient->delete('作品', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            if ($response->getStatusCode() !== 204 && $response->getStatusCode() !== 200) {
                $errorMessages[] = "刪除作品資料失敗";
                $deleteSuccess = false;
            }
        } catch (Exception $e) {
            $errorMessages[] = "刪除作品時發生錯誤: " . $e->getMessage();
            $deleteSuccess = false;
        }
        
        // 3. 刪除學生資料
        try {
            $response = $supabaseClient->delete('學生', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            if ($response->getStatusCode() !== 204 && $response->getStatusCode() !== 200) {
                $errorMessages[] = "刪除學生資料失敗";
                $deleteSuccess = false;
            }
        } catch (Exception $e) {
            $errorMessages[] = "刪除學生時發生錯誤: " . $e->getMessage();
            $deleteSuccess = false;
        }
        
        // 4. 刪除指導老師資料
        try {
            $response = $supabaseClient->delete('指導老師', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            if ($response->getStatusCode() !== 204 && $response->getStatusCode() !== 200) {
                $errorMessages[] = "刪除指導老師資料失敗";
                $deleteSuccess = false;
            }
        } catch (Exception $e) {
            $errorMessages[] = "刪除指導老師時發生錯誤: " . $e->getMessage();
            $deleteSuccess = false;
        }
        
        // 5. 最後刪除隊伍資料
        try {
            $response = $supabaseClient->delete('隊伍', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            
            if ($response->getStatusCode() !== 204 && $response->getStatusCode() !== 200) {
                $errorMessages[] = "刪除隊伍資料失敗";
                $deleteSuccess = false;
            }
        } catch (Exception $e) {
            $errorMessages[] = "刪除隊伍時發生錯誤: " . $e->getMessage();
            $deleteSuccess = false;
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
            $redirectParams['delete_error'] = implode('; ', $errorMessages);
        }
        
        // 重定向回評分檢視頁面
        echo '<form id="redirectForm" method="POST" action="view_scores.php">';
        foreach ($redirectParams as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        
    } catch (Exception $e) {
        echo '<form id="redirectForm" method="POST" action="view_scores.php">';
        echo '<input type="hidden" name="username" value="' . htmlspecialchars($username) . '">';
        echo '<input type="hidden" name="password" value="' . htmlspecialchars($password) . '">';
        echo '<input type="hidden" name="year" value="' . htmlspecialchars($year) . '">';
        echo '<input type="hidden" name="delete_error" value="刪除過程中發生未預期的錯誤: ' . htmlspecialchars($e->getMessage()) . '">';
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
    }
} else {
    // 如果沒有正確的請求，重定向到評分檢視頁面
    header('Location: view_scores.php');
    exit;
}
?>
