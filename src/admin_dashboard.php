<?php include 'darkmode.php'; ?>
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

    // $sql = "SELECT * FROM 管理員_研發處 WHERE 員工編號 = '".$filename."' and 密碼 = '".$filepasswd."'";
    // $result = mysqli_query($link, $sql);
    // $name = mysqli_fetch_array($result);
    if (count($data) === 1) {
        echo '<h2>歡迎，' . $filename . ' 管理員！</h2>';
        echo '
        <div class="admin-buttons">
            <form action="view_teams.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢隊伍資料</button>
            </form>
            <form action="view_students.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢學生資料</button>
            </form>
            <form action="admin_judges.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢評審資料</button>
            </form>
            <form action="view_teachers.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢指導老師資料</button>
            </form>
            <form action="announcements.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">公告重要事項</button>
            </form>
            </div>';
    } else {
        echo '<h2>登入失敗，請返回並重試。</h2>';
        echo '<P>管理員帳號密碼提示</P>';
        echo '<p>管理員帳號：員工編號</p>';
        echo '<p>管理員密碼：密碼</p>';
        echo '
            <div class="button-container">    
                <a href="admin.php" class="system-button">返回</a>
            </div>';
    }
    ?>
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