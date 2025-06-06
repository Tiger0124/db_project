<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/post_announcement.css">
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

    // 1. 接收表單的文字內容
    $announcement_content = $_POST['announcement_content'];
    $competition_rules = $_POST['competition_rules'];

    // 2. 準備更新內容
    $update_data = [
        '比賽規則' => $competition_rules,
        '公告內容' => $announcement_content
    ];

    // 3. 若有檔案上傳，才加入宣傳海報欄位
    if (isset($_FILES['announcement_file']) && $_FILES['announcement_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['announcement_file']['tmp_name'];
        $update_data['宣傳海報'] = base64_encode(file_get_contents($file_tmp_name));
    }

    // 4. 執行 PATCH 更新
    $response = $supabaseClient->patch('創意競賽', [
        'query' => [
            '屆數' => 'eq.13'
        ],
        'json' => $update_data
    ]);

    if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
        echo "<h2>公告發布成功！</h2>";
    } else {
        echo "<h2>公告發布失敗！</h2>";
    }

    //回主畫面
    echo "<form action='admin_dashboard.php' method='POST'>";
    echo "<input type='hidden' name='username' value='" . $_POST['username'] . "'>";
    echo "<input type='hidden' name='password' value='" . $_POST['password'] . "'>";
    echo "<button type='submit'>返回</button>";
    echo "</form>";
    ?>
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