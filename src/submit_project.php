<?php include 'darkmode.php'; ?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作品更新 - 高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/submit_project.css">
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
        // 設定台灣時區
        date_default_timezone_set('Asia/Taipei');

        // 包含資料庫連接文件
        include 'conn.php';

        // 接收表單的文字內容
        $video_url = $_POST['video_url'] ?? null;
        $code_url = $_POST['code_url'] ?? null;
        $pro_name = $_POST['pro_name'] ?? null;
        $pro_des = $_POST['pro_des'] ?? null;
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $year = date("Y");

        $update_success = true;
        $error_message = "";
        $manual_path = null;
        $poster_path = null;
        $is_update = false;

        try {
            // 檢查是否已有作品記錄

            $response = $supabaseClient->get('學生', [
                'query' => [
                    '學號' => 'eq.' . $username,
                    '身分證字號' => 'eq.' . $password,
                    'select' => '*',
                ]
            ]);


            $data = json_decode($response->getBody(), true);

            $team_id = $data[0]['隊伍編號'];


            $checkResponse = $supabaseClient->get('作品', [
                'query' => [
                    'select' => '隊伍編號,說明書,海報',
                    '隊伍編號' => 'eq.' . $team_id,
                    '參加年份' => 'eq.' . $year
                ]
            ]);

            $existingProject = null;
            if ($checkResponse->getStatusCode() === 200) {
                $projects = json_decode($checkResponse->getBody(), true);
                if (count($projects) > 0) {
                    $existingProject = $projects[0];
                    $is_update = true;
                }
            }

            // 準備更新數據
            $updateData = [];
            if (!empty($pro_name)) $updateData['作品名稱'] = $pro_name;
            if (!empty($pro_des)) $updateData['作品描述'] = $pro_des;
            if (!empty($video_url)) $updateData['作品展示(youtube連結)'] = $video_url;
            if (!empty($code_url)) $updateData['程式碼(Github連結)'] = $code_url;

            // 處理說明書上傳
            if (isset($_FILES['manual_file']) && $_FILES['manual_file']['error'] === UPLOAD_ERR_OK) {
                $file_tmp_name = $_FILES['manual_file']['tmp_name'];
                $updateData['說明書'] = base64_encode(file_get_contents($file_tmp_name));
            }

            // 處理海報上傳
            if (isset($_FILES['poster_file']) && $_FILES['poster_file']['error'] === UPLOAD_ERR_OK) {
                $file_tmp_name = $_FILES['poster_file']['tmp_name'];

                $updateData['海報'] = base64_encode(file_get_contents($file_tmp_name));
            }

            // 如果有數據需要更新
            if (!empty($updateData)) {
                if ($is_update) {
                    // 更新現有記錄
                    $response = $supabaseClient->patch('作品', [
                        'json' => $updateData,
                        'query' => [
                            '隊伍編號' => 'eq.' . $existingProject['隊伍編號']
                        ]
                    ]);
                    $successCode = 200;
                } else {
                    // 創建新記錄
                    $updateData['隊伍編號'] = $team_id;
                    $updateData['參加年份'] = $year;

                    $response = $supabaseClient->post('作品', [
                        'json' => $updateData
                    ]);
                    $successCode = 201;
                }



                echo '<div class="result-container success">';
                echo '<div class="result-icon success-icon">✓</div>';
                echo '<h2 class="result-title success-title">作品' . ($is_update ? '更新' : '上傳') . '成功！</h2>';
                echo '<div class="result-details">';
                if (!empty($pro_name)) echo '<p><strong>作品名稱：</strong>' . htmlspecialchars($pro_name) . '</p>';
                echo '<p><strong>操作時間：</strong>' . date('Y-m-d H:i:s') . '</p>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="result-container info">';
                echo '<div class="result-icon info-icon">i</div>';
                echo '<h2 class="result-title info-title">沒有變更需要更新</h2>';
                echo '</div>';
            }
        } catch (Exception $e) {
            echo '<div class="result-container error">';
            echo '<div class="result-icon error-icon">✗</div>';
            echo '<h2 class="result-title error-title">操作失敗！</h2>';
            echo '<div class="result-details">';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>

        <div class="action-section">
            <form action="student_dashboard.php" method="POST" class="return-form">
                <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                <button type="submit" class="return-btn">返回主頁</button>
            </form>
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