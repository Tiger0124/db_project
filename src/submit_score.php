<?php
// 設定時區
date_default_timezone_set('Asia/Taipei');

include 'conn.php';

$messages = [];
$success = true;
$username = '';
$judgeId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scores = $_POST['scores']; // 所有評分
    $teamIds = $_POST['team_ids']; // 隊伍編號
    $sessions = $_POST['sessions']; // 屆數
    $username = $_POST['username']; // 評審帳號
    $judgeId = $_POST['judge_id']; // 評審身分證(密碼)

    $currentYear = date("Y");

    foreach ($scores as $teamId => $score) {
        $session = $sessions[$teamId]; // 取得對應屆數
        
        // 使用預處理語句防止SQL注入
        $sql = "INSERT INTO 評分資料 (評分, 參加年份, 隊伍編號, 身分證字號, 屆數) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "sisss", $score, $currentYear, $teamId, $judgeId, $session);

        if (mysqli_stmt_execute($stmt)) {
            $messages[] = ['type' => 'success', 'text' => "隊伍 $teamId 的評分已成功提交！"];
        } else {
            $success = false;
            $messages[] = ['type' => 'error', 'text' => "隊伍 $teamId 的評分提交失敗：" . mysqli_error($link)];
        }
        mysqli_stmt_close($stmt);
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
                    <input type="hidden" name="password" value="<?= htmlspecialchars($judgeId) ?>">
                    <button type="submit" class="return-btn">返回評審系統</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; Copyright © 2025 XC Lee Tiger Lin  How Ho. All rights reserved.</p>
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
