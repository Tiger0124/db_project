<?php
include 'conn.php';

$team_id = $_POST['team_id'];
$username = $_POST['username'];
$password = $_POST['password'];
$member_count = $_POST['member_count'];

$success = true;
$error_messages = [];
$updated_items = [];

try {
    // Update student data
    for ($i = 0; $i < $member_count; $i++) {
        if (isset($_POST["student{$i}_id"])) {
            $student_id = $_POST["student{$i}_id"];
            $student_data = [
                '學號' => $_POST["student{$i}_studentid"],
                '姓名' => $_POST["student{$i}_name"],
                '電子郵件' => $_POST["student{$i}_email"],
                '電話' => $_POST["student{$i}_phone"],
                '科系' => $_POST["student{$i}_department"],
                '年級' => $_POST["student{$i}_grade"]
            ];

            $response = $supabaseClient->from('學生')
                ->update($student_data)
                ->eq('身分證字號', $student_id)
                ->eq('隊伍編號', $team_id)
                ->execute();

            if ($response->getStatusCode() === 200 && $response->getData()) {
                $updated_items[] = "學生 " . ($i + 1) . " (" . $student_data['姓名'] . ")";
            } else {
                throw new Exception("更新學生 " . ($i + 1) . " 資料失敗");
            }
        }
    }

    // Update professor data
    if (isset($_POST['professor_id'])) {
        $professor_id = $_POST['professor_id'];
        $professor_data = [
            '姓名' => $_POST['professor_name'],
            '電子郵件' => $_POST['professor_email'],
            '電話' => $_POST['professor_phone']
        ];

        $response = $supabaseClient->from('指導老師')
            ->update($professor_data)
            ->eq('身分證字號', $professor_id)
            ->eq('隊伍編號', $team_id)
            ->execute();

        if ($response->getStatusCode() === 200 && $response->getData()) {
            $updated_items[] = "指導老師 (" . $professor_data['姓名'] . ")";
        } else {
            throw new Exception("更新指導老師資料失敗");
        }
    }
} catch (Exception $e) {
    $success = false;
    $error_messages[] = $e->getMessage();
}
?>

<div class="result-container">
    <?php if ($success): ?>
        <div class="success-section">
            <div class="success-icon">✓</div>
            <h2>資料修改成功！</h2>
            <div class="success-details">
                <h3>已更新的資料：</h3>
                <ul class="updated-list">
                    <?php foreach ($updated_items as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="update-time">更新時間：<?= date('Y-m-d H:i:s') ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="error-section">
            <div class="error-icon">✗</div>
            <h2>資料修改失敗</h2>
            <div class="error-details">
                <h3>錯誤訊息：</h3>
                <ul class="error-list">
                    <?php foreach ($error_messages as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>