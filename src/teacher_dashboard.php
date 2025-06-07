<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/teacher_dashboard.css">
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

        try {
            // 查詢 Supabase「指導老師」資料表中是否有符合的紀錄
            $response = $supabaseClient->get('指導老師', [
                'query' => [
                    '身分證字號' => 'eq.' . $filename,
                    '密碼' => 'eq.' . $filepasswd
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (count($data) === 1) {
                $name = $data[0];
                
                // 歡迎區塊
                echo '<div class="welcome-section">';
                echo '<div class="welcome-header">';
                echo '<div class="teacher-icon">👨‍🏫</div>';
                echo '<h2 class="welcome-title">歡迎，' . htmlspecialchars($name['姓名']) . ' 教授！</h2>';
                echo '<div class="status-badge">';
                echo '<span class="status-label">身份：</span>';
                echo '<span class="status-value">指導教師</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // 儀表板容器
                echo '<div class="dashboard-container">';
                echo '<div class="buttons-grid">';

                // 查看指導學生資料按鈕
                echo '<form action="teacher_view.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn view-student-btn">';
                echo '<span class="btn-icon">👥</span>';
                echo '<span class="btn-text">查看指導學生資料</span>';
                echo '</button>';
                echo '</form>';

                // 查看歷屆作品按鈕
                echo '<form action="student_history.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn history-btn">';
                echo '<span class="btn-icon">📚</span>';
                echo '<span class="btn-text">查看歷屆作品</span>';
                echo '</button>';
                echo '</form>';

                // 編輯個人資料按鈕
                echo '<form action="teacher_profile.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn edit-btn">';
                echo '<span class="btn-icon">✏️</span>';
                echo '<span class="btn-text">編輯個人資料</span>';
                echo '</button>';
                echo '</form>';

                // 查看評分及評語按鈕
                echo '<form action="teacher_viewfeedback.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn feedback-btn">';
                echo '<span class="btn-icon">📊</span>';
                echo '<span class="btn-text">查看評分及評語</span>';
                echo '</button>';
                echo '</form>';

                // 修改密碼按鈕
                echo '<form action="teacher_changepassword.php" method="POST" class="dashboard-form">';
                echo '<input type="hidden" name="username" value="' . htmlspecialchars($_POST['username']) . '">';
                echo '<input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">';
                echo '<button type="submit" class="dashboard-btn password-btn">';
                echo '<span class="btn-icon">🔐</span>';
                echo '<span class="btn-text">修改密碼</span>';
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
                echo '<p class="error-message">帳號或密碼不正確，請檢查後重試</p>';

                echo '<div class="help-section">';
                echo '<h3 class="help-title">登入資訊提醒</h3>';
                echo '<div class="help-content">';
                echo '<div class="help-item">';
                echo '<span class="help-label">教師帳號：</span>';
                echo '<span class="help-value">身分證字號</span>';
                echo '</div>';
                echo '<div class="help-item">';
                echo '<span class="help-label">教師密碼：</span>';
                echo '<span class="help-value">設定的密碼</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="action-section">';
                echo '<a href="teacher.php" class="retry-button">重新登入</a>';
                echo '<a href="main.php" class="home-button">返回首頁</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

        } catch (Exception $e) {
            echo '<div class="error-container">';
            echo '<div class="error-content">';
            echo '<div class="error-icon">⚠️</div>';
            echo '<h2 class="error-title">系統錯誤</h2>';
            echo '<p class="error-message">' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<div class="action-section">';
            echo '<a href="teacher.php" class="retry-button">重新嘗試</a>';
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
