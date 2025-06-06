<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 準備新增資料
        $team_data = [
            '隊伍名稱' => $_POST['team_name'],
            '參加年份' => (int)$_POST['year'],
            '指導老師' => $_POST['teacher_id']
        ];
        
        // 新增隊伍資料到 Supabase
        $response = $supabaseClient->request('POST', '隊伍', [
            'json' => $team_data,
            'headers' => [
                'Prefer' => 'return=representation'
            ]
        ]);
        
        $status_code = $response->getStatusCode();
        $response_body = json_decode($response->getBody()->getContents(), true);
        
        if ($status_code === 201) {
            $team_id = $response_body[0]['id'];
            
            // 新增學生資料
            $students = explode(',', $_POST['students']);
            foreach ($students as $student_name) {
                $student_data = [
                    '姓名' => trim($student_name),
                    '隊伍' => $team_id
                ];
                
                $student_response = $supabaseClient->request('POST', '學生', [
                    'json' => $student_data
                ]);
            }
            
            // 新增作品資料
            $project_data = [
                '作品名稱' => $_POST['project_name'],
                '作品描述' => $_POST['project_description'],
                '隊伍' => $team_id
            ];
            
            $project_response = $supabaseClient->request('POST', '作品', [
                'json' => $project_data
            ]);
            
            echo json_encode(['success' => true, 'message' => '新增成功']);
        } else {
            echo json_encode(['success' => false, 'message' => '新增失敗']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增學生資料</title>
    <link rel="stylesheet" href="view_students.css">
</head>
<body>
    <div class="form-container">
        <h2>新增學生資料</h2>
        <form id="addStudentForm" method="POST">
            <div class="form-group">
                <label for="team_name">隊伍名稱:</label>
                <input type="text" id="team_name" name="team_name" required>
            </div>
            
            <div class="form-group">
                <label for="year">參加年份:</label>
                <select id="year" name="year" required>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="teacher_id">指導老師ID:</label>
                <input type="number" id="teacher_id" name="teacher_id" required>
            </div>
            
            <div class="form-group">
                <label for="students">學生姓名 (用逗號分隔):</label>
                <input type="text" id="students" name="students" placeholder="張三, 李四, 王五" required>
            </div>
            
            <div class="form-group">
                <label for="project_name">作品名稱:</label>
                <input type="text" id="project_name" name="project_name" required>
            </div>
            
            <div class="form-group">
                <label for="project_description">作品描述:</label>
                <textarea id="project_description" name="project_description" rows="4" required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">新增</button>
                <button type="button" onclick="history.back()" class="btn-cancel">取消</button>
            </div>
        </form>
    </div>
</body>
</html>
