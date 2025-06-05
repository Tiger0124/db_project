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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 從表單獲取資料
            $student1_id = $_POST['student1_id'];
            $student1_name = $_POST['student1_name'];
            $student1_email = $_POST['student1_email'];
            $student1_phone = $_POST['student1_phone'];
            $student1_department = $_POST['student1_department'];
            $student1_session = $_POST['student1_session'];
            $password = $_POST['password'];

            try {
                // 發送 PATCH 請求到 Supabase
                $response = $supabaseClient->patch('評審委員', [
                    'query' => [
                        '身分證字號' => 'eq.'.$student1_id,
                        '密碼' => 'eq.'.$password,
                    ],
                    'json' => [
                        '姓名' => $student1_name,
                        '電子郵件' => $student1_email,
                        '電話' => $student1_phone,
                        '頭銜' => $student1_department
                    ]
                ]);

                $bodyContents = $response->getBody()->getContents();
                var_dump($bodyContents); // 先看回傳結果
                $data = json_decode($bodyContents, true); // 再 decode
                var_dump($data); // 檢查解碼後的資料

                if ($data !== null) {
                    echo "✅ 查到 " . count($data) . " 筆資料<br>";
                    $success = true;
                    $updated_data = $data[0]; // 更新後回傳的第一筆資料
                } else {
                    $error_message = "沒有資料被更新，請確認資料是否正確。";
                }

            } catch (Exception $e) {
                $error_message = "更新失敗：" . $e->getMessage();
            }
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
                <form action="judge_dashboard.php" method="POST">
                    <?php
                    // 傳遞使用者名稱和密碼到評審系統
                    echo '<input type="hidden" name="username" value="'.$_POST['username'].'">
                    <input type="hidden" name="password" value="'.$_POST['password'].'">
                    <button type="submit" class="dashboard-btn">返回評審系統</button>';
                    ?>

                    <!-- <a href="judge_dashboard.php" class="dashboard-btn">返回評審系統</a> -->
                </form>

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
