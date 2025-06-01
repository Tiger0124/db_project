<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="post_announcement.css">
</head>
<body>
    <header>
    <div class="navbar">
        <a href="main.php" alt="Logo" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
        </a>
        <h1>高雄大學激發學生創意競賽管理系統</h1>
    </div>
    </header>
<?php
include 'conn.php';

// 1. 接收表單的文字內容
$announcement_content = $_POST['announcement_content'];
$competition_rules = $_POST['competition_rules'];

// 2. 檢查檔案是否存在並處理
if (isset($_FILES['announcement_file']) && $_FILES['announcement_file']['error'] === UPLOAD_ERR_OK) {
    // 檔案資訊
    $file_tmp_name = $_FILES['announcement_file']['tmp_name']; // 臨時檔案路徑
    $file_name = $_FILES['announcement_file']['name'];         // 原始檔名
    $file_size = $_FILES['announcement_file']['size'];         // 檔案大小
    $file_type = $_FILES['announcement_file']['type'];         // 檔案類型

    // 檢查檔案大小 (可選)
    if ($file_size > 10 * 1024 * 1024) { // 限制 10MB
        die("檔案過大，請上傳小於 10MB 的檔案。");
    }

    // 讀取檔案內容並轉換為 BLOB
    $file_content = file_get_contents($file_tmp_name);
    $file_content = mysqli_real_escape_string($link, $file_content);

    $sql="Update 創意競賽 set 公告內容 = '".$announcement_content."', 比賽規則 = '".$competition_rules."', 宣傳海報 = '".$file_content."' where 屆數 = '第13屆'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo "<h2>公告發布成功！</h2>";
    } else {
        echo "<h2>公告發布失敗！</h2>";
    }
} else {
    echo "<h2>檔案上傳失敗！</h2>";
}

//回主畫面
echo "<form action='admin_dashboard.php' method='POST'>";
echo "<input type='hidden' name='username' value='".$_POST['username']."'>";
echo "<input type='hidden' name='password' value='".$_POST['password']."'>";
echo "<button type='submit'>返回</button>";
echo "</form>";
?>
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
