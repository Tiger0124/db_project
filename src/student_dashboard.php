<?php include 'darkmode.php'; ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/student_dashboard.css">
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
        <?php
        include 'conn.php';
        $filename = $_POST["username"];
        $filepasswd = $_POST["password"];

        // 發送 GET 請求查詢符合條件的學生
        $response = $supabaseClient->get('學生', [
            'query' => [
                '學號' => 'eq.' . $filename,
                '身分證字號' => 'eq.' . $filepasswd,
                'select' => '*',
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (count($data) === 1) {
            $name = $data[0]['姓名'];
            $team_id = $data[0]['隊伍編號'];

            $team_response = $supabaseClient->get('隊伍', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id,
                    'select' => '報名進度'
                ]
            ]);
            $members = json_decode($team_response->getBody(), true);

            if (!$team_id) {
                $status = '未報名';
                $members = [['報名進度' => '未報名']];
            } else {
                $status = $members[0]['報名進度'];
            }

            echo '<div class="welcome-section">';
            echo '<div class="welcome-header">';
            echo '<div class="student-icon">🎓</div>';
            echo '<h2 class="welcome-title">歡迎，' . htmlspecialchars($name) . ' 同學！</h2>';
            echo '<div class="status-badge status-' . strtolower(str_replace(['未', '退'], ['un', 'reject'], $status)) . '">';
            echo '<span class="status-label">目前狀態：</span>';
            echo '<span class="status-value">' . htmlspecialchars($status) . '</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="dashboard-container">';
            echo '<div class="buttons-grid">';

            // 修改團隊資訊按鈕
            echo '<form action="student_edit.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn edit-btn">';
            echo '<span class="btn-icon">✏️</span>';
            echo '<span class="btn-text">修改團隊資訊</span>';
            echo '</button>';
            echo '</form>';

            // 根據報名進度顯示不同按鈕
            if ($members[0]['報名進度'] == '未報名') {
                echo '<div class="dashboard-form">';
                echo '<button type="button" class="dashboard-btn disabled-btn" disabled>';
                echo '<span class="btn-icon">🚫</span>';
                echo '<span class="btn-text">請先報名</span>';
                echo '</button>';
                echo '</div>';
            } else if ($members[0]['報名進度'] != '退件') {
                echo '<form action="student_upload.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn upload-btn">';
                echo '<span class="btn-icon">📤</span>';
                echo '<span class="btn-text">上傳作品</span>';
                echo '</button>';
                echo '</form>';
            } else {
                echo '<form action="student_reregister.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn reregister-btn">';
                echo '<span class="btn-icon">🔄</span>';
                echo '<span class="btn-text">重新報名</span>';
                echo '</button>';
                echo '</form>';
            }

            // 歷屆作品瀏覽按鈕
            echo '<form action="student_history_login.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn history-btn">';
            echo '<span class="btn-icon">📚</span>';
            echo '<span class="btn-text">歷屆作品瀏覽</span>';
            echo '</button>';
            echo '</form>';

            // 報名參賽按鈕
            echo '<form action="student_register.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn register-btn">';
            echo '<span class="btn-icon">📝</span>';
            echo '<span class="btn-text">報名參賽</span>';
            echo '</button>';
            echo '</form>';

            echo '</div>'; // buttons-grid
            echo '</div>'; // dashboard-container

        } else {
            echo '<div class="error-container">';
            echo '<div class="error-content">';
            echo '<div class="error-icon">🔒</div>';
            echo '<h2 class="error-title">登入失敗</h2>';
            echo '<p class="error-message">請返回並重試</p>';

            echo '<div class="help-section">';
            echo '<h3 class="help-title">學生帳號密碼提示</h3>';
            echo '<div class="help-content">';
            echo '<div class="help-item">';
            echo '<span class="help-label">帳號：</span>';
            echo '<span class="help-value">學號</span>';
            echo '</div>';
            echo '<div class="help-item">';
            echo '<span class="help-label">密碼：</span>';
            echo '<span class="help-value">身分證字號</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="action-section">';
            echo '<a href="student_login.php" class="retry-button">返回登入</a>';
            echo '<a href="main.php" class="home-button">返回首頁</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
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
