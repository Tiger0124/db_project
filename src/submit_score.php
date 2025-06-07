<?php include 'darkmode.php'; ?>
<?php
// 設定時區
date_default_timezone_set('Asia/Taipei');

include 'conn.php';

$messages = [];
$success = true;
$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scores_new = $_POST['scores_new']; // 評分資料
    $scores_use = $_POST['scores_use']; // 評分資料
    $scores_integrity = $_POST['scores_integrity']; // 評分資料
    $comments = $_POST['comments']; // 評語資料
    $teamIds = $_POST['team_ids']; // 隊伍編號
    $sessions = $_POST['sessions']; // 屆數
    $username = $_POST['username']; // 評審身分證(帳號)
    // $username = str_pad($username, 12);  // 若 CHAR(12)
    $password = trim($_POST['password']); // 評審密碼(密碼)
    $currentYear = date("Y");

    foreach ($teamIds as $teamId) {
        $session = trim($sessions[$teamId]);
        $score_new = $scores_new[$teamId];
        $score_use = $scores_use[$teamId];
        $score_integrity = $scores_integrity[$teamId];
        $comment = $comments[$teamId];

        $supabaseUrl = 'https://xlomzrhmzjjfjmsvqxdo.supabase.co/rest/v1/評分資料';
        $supabaseApiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo';

        try {
            $response = $supabaseClient->request('POST', $supabaseUrl, [
                'headers' => [
                    'apikey' => $supabaseApiKey,
                    'Authorization' => 'Bearer ' . $supabaseApiKey,
                    'Content-Type' => 'application/json',
                    'Prefer' => 'return=representation'
                ],
                'json' => [
                    '參加年份' => $currentYear,
                    '隊伍編號' => $teamId,
                    '身分證字號' => $username,
                    '屆數' => (string)$session,
                    '創意性' => (int)$score_new,
                    '實用性' => (int)$score_use,
                    '完整性' => (int)$score_integrity,
                    '評語' => $comment
                ]
            ]);

            $messages[] = ['type' => 'success', 'text' => "隊伍 $teamId 評分成功送出"];
        } catch (Exception $e) {
            $messages[] = ['type' => 'error', 'text' => "隊伍 $teamId 評分失敗：" . $e->getMessage()];
            $success = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>評分提交結果 - 高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/submit_score.css">
</head>

<body>
    <header>
        <div class="navbar">
            <a href="main.php" alt="Logo" class="logo">
                <img src="../images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main id="content">
        <div class="result-container">
            <h2>評分提交結果</h2>

            <div class="messages-container">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="message <?= $message['type'] ?>">
                            <div class="message-icon">
                                <?= $message['type'] === 'success' ? '✓' : '✗' ?>
                            </div>
                            <div class="message-text">
                                <?= htmlspecialchars($message['text']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="message error">
                        <div class="message-icon">✗</div>
                        <div class="message-text">沒有收到評分資料</div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="summary">
                <?php if ($success): ?>
                    <div class="summary-success">
                        <div class="summary-icon">🎉</div>
                        <p>所有評分已成功提交！</p>
                        <p class="timestamp">提交時間：<?= date('Y-m-d H:i:s') ?></p>
                    </div>
                <?php else: ?>
                    <div class="summary-error">
                        <div class="summary-icon">⚠️</div>
                        <p>部分評分提交失敗，請檢查錯誤訊息</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="action-buttons">
                <form action="judge_dashboard.php" method="POST">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                    <button type="submit" class="return-btn">返回評審系統</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; Copyright © 2025 XC Lee Tiger Lin How Ho. All rights reserved.</p>
            <div class="footer-row">
                <div class="footer-container">
                    <p>聯絡我們 : <a href="mailto:wylin@nuk.edu.tw">wylin@nuk.edu.tw</a></p>
                </div>
                <ul class="footer-links">
                    <li><a href="https://github.com/Tiger0124/db_project.git">關於我們</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>