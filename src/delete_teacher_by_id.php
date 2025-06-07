<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['teacher_id'])) {
    $teacher_id = $_POST['teacher_id'];
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $year = $_POST['year'] ?? '';
    
    try {
        $response = $supabaseClient->delete('指導老師', [
            'query' => [
                '身分證字號' => 'eq.' . $teacher_id
            ]
        ]);
        
        $redirectParams = [
            'username' => $username,
            'password' => $password,
            'year' => $year
        ];
        
        if ($response->getStatusCode() === 204 || $response->getStatusCode() === 200) {
            $redirectParams['delete_success'] = '1';
            $redirectParams['delete_message'] = '指導老師資料刪除成功！';
        } else {
            $redirectParams['delete_error'] = '刪除指導老師資料失敗';
        }
        
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
        echo '<input type="hidden" name="delete_error" value="刪除過程中發生錯誤: ' . htmlspecialchars($e->getMessage()) . '">';
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
    }
} else {
    header('Location: view_teachers.php');
    exit;
}
?>
