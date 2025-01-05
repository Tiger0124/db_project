<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="styles.css">
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
    <main id="content">
    <?php
            
        if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
            echo '<h2>歡迎，xx教授！</h2>';
            echo '
            <div class="buttons">
                <form action="teacher_view.php" method="post">
                    <input type="hidden" name="username" value="' . $_POST['username'] . '">
                    <input type="hidden" name="password" value="' . $_POST['password'] . '">
                    <input type="submit" value="查看指導學生資料">
                </form>
                <form action="student_history.php" method="post">
                    <input type="hidden" name="username" value="' . $_POST['username'] . '">
                    <input type="hidden" name="password" value="' . $_POST['password'] . '">
                    <input type="submit" value="查看歷屆作品">
                </form>
            </div>';
        } else {
            echo '<p>登入失敗，請返回並重試。</p>';
            echo '<a href="student_login.php">返回</a>';
        }
        ?>
    </main>
</body>
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
</html>
