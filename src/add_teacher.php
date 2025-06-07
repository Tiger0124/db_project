<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = $_POST['id_number'];
    $teacher_name = $_POST['teacher_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $teacher_password = $_POST['teacher_password'];
    $participate_year = $_POST['participate_year'];
    $team_id = trim($_POST['team_id']);
    
    try {
        // 驗證必要欄位（移除 team_id 的必要性檢查）
        if (empty($id_number) || empty($teacher_name) || empty($phone) || empty($email) || empty($title) || empty($teacher_password) || empty($participate_year)) {
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
        
        // 檢查密碼長度
        if (strlen($teacher_password) < 6) {
            echo "<script>
                alert('密碼長度至少需要6位！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 檢查身分證字號是否已存在
        $checkIdResponse = $supabaseClient->get('指導老師', [
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
        
        // 檢查電子郵件是否已存在
        $checkEmailResponse = $supabaseClient->get('指導老師', [
            'query' => [
                '電子郵件' => 'eq.' . $email,
                'select' => '*',
            ]
        ]);
        
        $existingEmail = json_decode($checkEmailResponse->getBody()->getContents(), true);
        
        if (!empty($existingEmail)) {
            echo "<script>
                alert('此電子郵件已存在！');
                window.history.back();
            </script>";
            exit;
        }
        
        // 準備新增資料的基本欄位
        $teacherData = [
            '身分證字號' => $id_number,
            '姓名' => $teacher_name,
            '電話' => $phone,
            '電子郵件' => $email,
            '職稱' => $title,
            '密碼' => $teacher_password,
            '參加年份' => $participate_year
        ];
        
        $teamName = null;
        
        // 如果有填寫隊伍編號，則進行相關檢查
        if (!empty($team_id)) {
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
            
            // 檢查該隊伍是否已有指導老師
            $existingTeacherInTeam = $supabaseClient->get('指導老師', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id,
                    '參加年份' => 'eq.' . $participate_year,
                    'select' => '*',
                ]
            ]);
            
            $existingTeacherData = json_decode($existingTeacherInTeam->getBody()->getContents(), true);
            
            if (!empty($existingTeacherData)) {
                echo "<script>
                    alert('隊伍編號「" . addslashes($team_id) . "」在 " . addslashes($participate_year) . " 年度已有指導老師！');
                    window.history.back();
                </script>";
                exit;
            }
            
            // 如果隊伍編號檢查通過，加入到資料中
            $teacherData['隊伍編號'] = $team_id;
            $teamName = $teamData[0]['隊伍名稱'] ?? '未知';
        }
        
        // 新增指導老師資料
        $response = $supabaseClient->post('指導老師', [
            'json' => $teacherData
        ]);

        if ($response->getStatusCode() === 201) {
            // 準備成功訊息
            $successMessage = "指導老師新增成功！\\n身分證字號：" . addslashes($id_number) . "\\n姓名：" . addslashes($teacher_name) . "\\n職稱：" . addslashes($title) . "\\n參加年份：" . addslashes($participate_year);
            
            // 如果有指定隊伍，加入隊伍資訊
            if (!empty($team_id) && $teamName) {
                $successMessage .= "\\n指導隊伍：" . addslashes($teamName) . "（編號：" . addslashes($team_id) . "）";
            } else {
                $successMessage .= "\\n指導隊伍：尚未指定";
            }
            
            echo "<script>
                alert('" . $successMessage . "');
                window.location.href = 'view_teachers.php';
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
