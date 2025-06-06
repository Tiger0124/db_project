<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $participate_year = $_POST['participate_year'];
    $team_id = trim($_POST['team_id']);
    
    try {
        // 驗證必要欄位
        if (empty($student_id) || empty($student_name) || empty($id_number) || empty($participate_year) || empty($team_id)) {
            echo "<script>
                alert('請填寫所有必要欄位！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 檢查身分證字號格式
        if (!preg_match('/^[A-Z][0-9]{9}$/', $id_number)) {
            echo "<script>
                alert('身分證字號格式錯誤！請輸入正確格式（例：A123456789）');
                window.history.back();
            </script>";
            exit;
        }
        
        // 檢查學號是否已存在
        $checkStudentResponse = $supabaseClient->get('學生', [
            'query' => [
                '學號' => 'eq.' . $student_id,
                'select' => '*',
            ]
        ]);
        
        $existingStudent = json_decode($checkStudentResponse->getBody()->getContents(), true);
        
        if (!empty($existingStudent)) {
            echo "<script>
                alert('此學號已存在！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 檢查身分證字號是否已存在
        $checkIdResponse = $supabaseClient->get('學生', [
            'query' => [
                '身分證字號' => 'eq.' . $id_number,
                'select' => '*',
            ]
        ]);
        
        $existingId = json_decode($checkIdResponse->getBody()->getContents(), true);
        
        if (!empty($existingId)) {
            echo "<script>
                alert('此身分證字號已存在！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 檢查隊伍編號是否存在且參加年份匹配
        $teamCheckResponse = $supabaseClient->get('隊伍', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id,
                '參加年份' => 'eq.' . $participate_year,
                'select' => '隊伍編號,隊伍名稱,參加年份',
            ]
        ]);
        
        $teamData = json_decode($teamCheckResponse->getBody()->getContents(), true);
        
        if (empty($teamData)) {
            echo "<script>
                alert('隊伍編號「" . addslashes($team_id) . "」在 " . addslashes($participate_year) . " 年度不存在！請確認隊伍編號和參加年份是否正確。');
                window.history.back();
            </script>";
            exit;
        }
        
        // 新增學生資料
        $response = $supabaseClient->post('學生', [
            'json' => [
                '學號' => $student_id,
                '姓名' => $student_name,
                '身分證字號' => $id_number,
                '電子郵件' => $email,
                '電話' => $phone,
                '參加年份' => $participate_year,
                '隊伍編號' => $team_id
            ]
        ]);

        if ($response->getStatusCode() === 201) {
            $teamName = $teamData[0]['隊伍名稱'] ?? '未知';
            echo "<script>
                alert('學生新增成功！\\n學號：" . addslashes($student_id) . "\\n姓名：" . addslashes($student_name) . "\\n參加年份：" . addslashes($participate_year) . "\\n隊伍：" . addslashes($teamName) . "');
                window.location.href = 'view_students.php';
            </script>";
        } else {
            $responseBody = $response->getBody()->getContents();
            echo "<script>
                alert('新增失敗，HTTP 狀態碼：" . $response->getStatusCode() . "\\n錯誤詳情：" . addslashes($responseBody) . "');
                window.history.back();
            </script>";
        }
        
    } catch (Exception $e) {
        echo "<script>
            alert('新增失敗：" . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('無效的請求方式！');
        window.history.back();
    </script>";
}
?>
