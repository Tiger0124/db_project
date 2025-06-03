<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="teacher_dashboard.css">
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
        include 'conn.php';
        $select_db = @mysqli_select_db($link, "db_project"); //選擇資料庫
        $filename=$_POST["username"];
        $filepasswd=$_POST["password"];   

        $sql = "SELECT * FROM 指導老師 WHERE 隊伍編號 = '".$filename."' and 身分證字號 = '".$filepasswd."'";
        $result = mysqli_query($link, $sql);
        $name = mysqli_fetch_array($result);
        if (mysqli_num_rows($result)==1) {
            echo '<h2>歡迎，'.$name['姓名'].' 教授！</h2>';
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
            echo '<h2>登入失敗，請返回並重試。</h2>';
            echo '<P>教師帳號密碼提示</P>';
            echo '<p>教師帳號：隊伍編號</p>';
            echo '<p>教師密碼：身分證字號</p>';
        echo '
            <div class="button-container">    
                <a href="teacher.php" class="system-button">返回</a>
            </div>';
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
