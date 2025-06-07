<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/judge_dashboard.css">
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
    <?php
include 'conn.php';
$filename = $_POST["username"];
$filepasswd = $_POST["password"];

// 發送 GET 請求查詢符合條件的使用者
$response = $supabaseClient->get('評審委員', [
    'query' => [
        '身分證字號' => 'eq.' . $filename,
        '密碼' => 'eq.' . $filepasswd,
        'select' => '*',
    ]
]);
$data = json_decode($response->getBody(), true);

if (count($data) === 1) {
    $name = $data[0]['姓名'];
    
    echo '<main id="content">';
    echo '<div class="welcome-section">';
    echo '<div class="welcome-header">';
    echo '<div class="judge-icon">⚖️</div>';
    echo '<h2 class="welcome-title">歡迎，' . htmlspecialchars($name) . ' 評審！</h2>';
    echo '<div class="status-badge">';
    echo '<span class="status-label">身份：</span>';
    echo '<span class="status-value">評審委員</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="dashboard-container">';
    echo '<div class="buttons-grid">';

    // 修改個人資料按鈕
    echo '<form action="edit_judge.php" method="POST" class="dashboard-form">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($filename) . '">';
    echo '<input type="hidden" name="password" value="' . htmlspecialchars($filepasswd) . '">';
    echo '<button type="submit" class="dashboard-btn edit-btn">';
    echo '<span class="btn-icon">✏️</span>';
    echo '<span class="btn-text">修改個人資料</span>';
    echo '</button>';
    echo '</form>';

    // 填寫評分分數按鈕
    echo '<form action="judgement.php" method="POST" class="dashboard-form">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($filename) . '">';
    echo '<input type="hidden" name="password" value="' . htmlspecialchars($filepasswd) . '">';
    echo '<button type="submit" class="dashboard-btn scoring-btn">';
    echo '<span class="btn-icon">📊</span>';
    echo '<span class="btn-text">填寫評分分數</span>';
    echo '</button>';
    echo '</form>';

    // 查看歷屆作品按鈕
    echo '<form action="student_history.php" method="POST" class="dashboard-form">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($filename) . '">';
    echo '<input type="hidden" name="password" value="' . htmlspecialchars($filepasswd) . '">';
    echo '<button type="submit" class="dashboard-btn history-btn">';
    echo '<span class="btn-icon">📚</span>';
    echo '<span class="btn-text">查看歷屆作品</span>';
    echo '</button>';
    echo '</form>';

    // 修改密碼按鈕
    echo '<form action="judge_changepassword.php" method="POST" class="dashboard-form">';
    echo '<input type="hidden" name="username" value="' . htmlspecialchars($filename) . '">';
    echo '<input type="hidden" name="password" value="' . htmlspecialchars($filepasswd) . '">';
    echo '<button type="submit" class="dashboard-btn password-btn">';
    echo '<span class="btn-icon">🔐</span>';
    echo '<span class="btn-text">修改密碼</span>';
    echo '</button>';
    echo '</form>';

    echo '</div>'; // buttons-grid
    echo '</div>'; // dashboard-container
    echo '</main>';

} else {
    echo '<main id="content">';
    echo '<div class="error-container">';
    echo '<div class="error-content">';
    echo '<div class="error-icon">🔒</div>';
    echo '<h2 class="error-title">登入失敗</h2>';
    echo '<p class="error-message">請返回並重試</p>';

    echo '<div class="help-section">';
    echo '<h3 class="help-title">評審帳號密碼提示</h3>';
    echo '<div class="help-content">';
    echo '<div class="help-item">';
    echo '<span class="help-label">帳號：</span>';
    echo '<span class="help-value">身分證字號</span>';
    echo '</div>';
    echo '<div class="help-item">';
    echo '<span class="help-label">密碼：</span>';
    echo '<span class="help-value">密碼</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="action-section">';
    echo '<a href="judge.php" class="retry-button">返回登入</a>';
    echo '<a href="main.php" class="home-button">返回首頁</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</main>';
}
?>

</body>
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

</html>