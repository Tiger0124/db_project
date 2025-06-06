<?php include 'darkmode.php'; ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/student.css">
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
        <h2 style="text-align: center;">學生系統</h2>
        <!-- <p>請選擇功能：</p> -->
        <div class="rounded-box">
            <div class="button-container">
                <a href="student_login.php" class="system-button">學生登入</a>
                <a href="student_register.php" class="system-button">報名系統</a>
                <a href="student_history.php" class="system-button">歷屆作品瀏覽</a>
            </div>
        </div>
    </main>
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