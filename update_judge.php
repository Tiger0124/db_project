<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>評審資料更新結果 - 高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="update_judge.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main id="content">
        <?php
        include 'conn.php';
        
        $success = false;
        $error_message = "";
        $updated_data = [];

        // 檢查是否是 POST 請求
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 從表單獲取資料
            $student1_id = $_POST['student1_id'];
            $student1_name = $_POST['student1_name'];
            $student1_email = $_POST['student1_email'];
            $student1_phone = $_POST['student1_phone'];
            $student1_department = $_POST['student1_department'];
            $student1_session = $_POST['student1_session'];
            $username = $_POST['student1_name'];
            $password = $_POST['student1_id'];

            // 使用預處理語句防止SQL注入
            $sql = "UPDATE 評審委員 
                    SET 姓名 = ?, 
                        電子郵件 = ?, 
                        電話 = ?, 
                        頭銜 = ? 
                    WHERE 身分證字號 = ? AND 屆數 = ?";

            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", 
                $student1_name, $student1_email, $student1_phone, 
                $student1_department, $student1_id, $student1_session);

            if (mysqli_stmt_execute($stmt)) {
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                if ($affected_rows > 0) {
                    $success = true;
                    $updated_data = [
                        '姓名' => $student1_name,
                        '電子郵件' => $student1_email,
                        '電話' => $student1_phone,
                        '頭銜' => $student1_department,
                        '身分證字號' => $student1_id,
                        '屆數' => $student1_session
                    ];
                } else {
                    $error_message = "沒有資料被更新，請檢查身分證字號和屆數是否正確。";
                }
            } else {
                $error_message = "資料庫更新失敗：" . mysqli_error($link);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($link);
        } else {
            $error_message = "無效的請求方式。";
        }
        ?>

        <div class="result-container">
            <?php if ($success): ?>
                <div class="success-section">
                    <div class="success-icon">✓</div>
                    <h2>評審資料更新成功！</h2>
                    <div class="success-details">
                        <h3>已更新的資料：</h3>
                        <div class="updated-info">
                            <?php foreach ($updated_data as $field => $value): ?>
                                <div class="info-row">
                                    <span class="field-name"><?= htmlspecialchars($field) ?>：</span>
                                    <span class="field-value"><?= htmlspecialchars($value) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <p class="update-time">更新時間：<?= date('Y-m-d H:i:s') ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="error-section">
                    <div class="error-icon">✗</div>
                    <h2>評審資料更新失敗</h2>
                    <div class="error-details">
                        <p><?= htmlspecialchars($error_message) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="action-buttons">
                <a href="judge_dashboard.php" class="dashboard-btn">返回評審系統</a>
                <a href="main.php" class="main-btn">返回首頁</a>
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
