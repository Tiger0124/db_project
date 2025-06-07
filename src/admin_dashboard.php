<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/admin_dashboard.css">
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
        
        // 發送 GET 請求查詢符合條件的使用者
        $response = $supabaseClient->get('管理員_研發處', [
            'query' => [
                '員工編號' => 'eq.' . $filename,
                '密碼' => 'eq.' . $filepasswd,
                'select' => '*',
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        if (count($data) === 1) {
            // 歡迎區塊
            echo '<div class="welcome-section">';
            echo '<div class="welcome-header">';
            echo '<div class="admin-icon">👨‍💼</div>';
            echo '<h2 class="welcome-title">歡迎，' . htmlspecialchars($filename) . ' 管理員！</h2>';
            echo '<div class="status-badge">';
            echo '<span class="status-label">身份：</span>';
            echo '<span class="status-value">系統管理員</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // 儀表板容器
            echo '<div class="dashboard-container">';
            echo '<div class="buttons-grid">';

            // 查詢隊伍資料按鈕
            echo '<form action="view_students.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn team-btn">';
            echo '<span class="btn-icon">👥</span>';
            echo '<span class="btn-text">查詢隊伍資料</span>';
            echo '</button>';
            echo '</form>';

            // 查詢評審資料按鈕
            echo '<form action="admin_judges.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn judge-btn">';
            echo '<span class="btn-icon">⚖️</span>';
            echo '<span class="btn-text">查詢評審資料</span>';
            echo '</button>';
            echo '</form>';

            // 查詢指導老師資料按鈕
            echo '<form action="view_teachers.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn teacher-btn">';
            echo '<span class="btn-icon">👨‍🏫</span>';
            echo '<span class="btn-text">查詢指導老師資料</span>';
            echo '</button>';
            echo '</form>';

            // 公告重要事項按鈕
            echo '<form action="announcements.php" method="POST" class="dashboard-form">';
            echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
            echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
            echo '<button type="submit" class="dashboard-btn announcement-btn">';
            echo '<span class="btn-icon">📢</span>';
            echo '<span class="btn-text">公告重要事項</span>';
            echo '</button>';
            echo '</form>';

            echo '</div>'; // buttons-grid
            echo '</div>'; // dashboard-container

        } else {
            // 錯誤訊息區塊
            echo '<div class="error-container">';
            echo '<div class="error-content">';
            echo '<div class="error-icon">🔒</div>';
            echo '<h2 class="error-title">登入失敗</h2>';
            echo '<p class="error-message">請返回並重試</p>';

            echo '<div class="help-section">';
            echo '<h3 class="help-title">管理員帳號密碼提示</h3>';
            echo '<div class="help-content">';
            echo '<div class="help-item">';
            echo '<span class="help-label">管理員帳號：</span>';
            echo '<span class="help-value">員工編號</span>';
            echo '</div>';
            echo '<div class="help-item">';
            echo '<span class="help-label">管理員密碼：</span>';
            echo '<span class="help-value">密碼</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="action-section">';
            echo '<a href="admin.php" class="retry-button">返回登入</a>';
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
