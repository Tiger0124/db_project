<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/judge_dashboard.css">
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
    $filename=$_POST["username"];
    $filepasswd=$_POST["password"];

    // 發送 GET 請求查詢符合條件的使用者
    $response = $supabaseClient->get('評審委員', [
            'query' => [
                '身分證字號' => 'eq.' . $filename,
                '密碼' => 'eq.' . $filepasswd,
                'select' => '*',
            ]
    ]);
    $data = json_decode($response->getBody(), true);

    if (count($data) === 1) {
        $name = $data[0]['姓名'];
        echo '<h2>歡迎，'.$name.' 評審！</h2>';
        echo '
        <div class="admin-buttons">
            <form action="edit_judge.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">修改個人資料</button>
            </form>
            <form action="judgement.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">填寫評分分數</button>
            </form>
            <form action="student_history.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查看歷屆作品</button>
            </form>
            </div>';
    } else {
        echo '<h2>登入失敗，請返回並重試。</h2>';
        echo '<P>評審帳號密碼提示</P>';
        echo '<p>評審帳號：姓名</p>';
        echo '<p>評審密碼：身分證字號</p>';
        echo '
            <div class="button-container">    
                <a href="judge.php" class="system-button">返回</a>
            </div>';
    }
    ?>
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