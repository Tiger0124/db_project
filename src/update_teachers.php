<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = $_POST['team_id'];
    $teacher_name = $_POST['teacher_name'];
    $teacher_title = $_POST['teacher_title'];
    $team_name = $_POST['team_name'];
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
                    '姓名' => $teacher_name,
                    '職稱' => $teacher_title
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

        // 處理學生資料更新
        if (!empty($students)) {
            // 先取得現有學生資料
            $currentStudentsResponse = $supabaseClient->get('學生', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id,
                    'select' => '*'
                ]
            ]);

            if ($currentStudentsResponse->getStatusCode() == 200) {
                $currentStudents = json_decode($currentStudentsResponse->getBody()->getContents(), true);
                
                // 解析新的學生名單
                $newStudentNames = array_map('trim', explode(',', $students));
                $newStudentNames = array_filter($newStudentNames); // 移除空值
                
                // 取得現有學生姓名
                $currentStudentNames = [];
                foreach ($currentStudents as $student) {
                    $currentStudentNames[] = $student['姓名'];
                }
                
                // 找出需要新增的學生
                $studentsToAdd = array_diff($newStudentNames, $currentStudentNames);
                
                // 找出需要刪除的學生
                $studentsToRemove = array_diff($currentStudentNames, $newStudentNames);
                
                // 新增學生
                foreach ($studentsToAdd as $studentName) {
                    $addStudentResponse = $supabaseClient->post('學生', [
                        'json' => [
                            '姓名' => $studentName,
                            '隊伍編號' => intval($team_id),
                            '學號' => 'AUTO_' . time() . '_' . rand(1000, 9999), // 自動生成學號
                            '電子郵件' => $studentName . '@example.com', // 預設郵件
                            '電話' => '0000000000' // 預設電話
                        ]
                    ]);
                }
                
                // 刪除學生
                foreach ($studentsToRemove as $studentName) {
                    $deleteStudentResponse = $supabaseClient->delete('學生', [
                        'query' => [
                            '隊伍編號' => 'eq.' . $team_id,
                            '姓名' => 'eq.' . $studentName
                        ]
                    ]);
                }
            }
        }

        // 重新導向回查詢頁面
        echo "<script>
            alert('教師資料更新成功！');
            window.location.href = 'view_teachers.php';
        </script>";
        
    } catch (Exception $e) {
        echo "<script>
            alert('更新失敗：" . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
}
?>
