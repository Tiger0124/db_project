<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = $_POST['team_id'];
    
    try {
        // 先刪除相關的學生資料
        $delete_students_response = $supabaseClient->request('DELETE', '學生', [
            'query' => [
                '隊伍' => 'eq.' . $team_id
            ]
        ]);
        
        // 刪除相關的作品資料
        $delete_projects_response = $supabaseClient->request('DELETE', '作品', [
            'query' => [
                '隊伍' => 'eq.' . $team_id
            ]
        ]);
        
        // 最後刪除隊伍資料
        $delete_team_response = $supabaseClient->request('DELETE', '隊伍', [
            'query' => [
                'id' => 'eq.' . $team_id
            ]
        ]);
        
        $status_code = $delete_team_response->getStatusCode();
        
        if ($status_code === 204 || $status_code === 200) {
            echo json_encode(['success' => true, 'message' => '刪除成功']);
        } else {
            echo json_encode(['success' => false, 'message' => '刪除失敗']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
