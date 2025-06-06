<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = $_POST['team_id'];
    $team_name = $_POST['team_name'];
    $teacher_name = $_POST['teacher_name'];
    $students = $_POST['students'];
    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    
    try {
        // 更新隊伍資料
        $teamResponse = $supabaseClient->patch('隊伍', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id
            ],
            'json' => [
                '隊伍名稱' => $team_name
            ]
        ]);

        // 更新指導老師資料
        if (!empty($teacher_name)) {
            $teacherResponse = $supabaseClient->patch('指導老師', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ],
                'json' => [
                    '姓名' => $teacher_name
                ]
            ]);
        }

        // 更新作品資料
        if (!empty($project_name)) {
            $projectResponse = $supabaseClient->patch('作品', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ],
                'json' => [
                    '作品名稱' => $project_name,
                    '作品描述' => $project_description
                ]
            ]);
        }

        // 重新導向回查詢頁面
        echo "<script>
            alert('資料更新成功！');
            window.location.href = 'view_students.php';
        </script>";
        
    } catch (Exception $e) {
        echo "<script>
            alert('更新失敗：" . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}
?>
