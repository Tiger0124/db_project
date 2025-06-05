<?php include 'darkmode.php'; ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/student_dashboard.css">
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

    // 發送 GET 請求查詢符合條件的學生
    $response = $supabaseClient->get('學生', [
        'query' => [
            '學號' => 'eq.' . $filename,
            '身分證字號' => 'eq.' . $filepasswd,
            'select' => '*',
        ]
    ]);


    $data = json_decode($response->getBody(), true);

    if (count($data) === 1) {
        $name = $data[0]['姓名'];
        $team_id = $data[0]['隊伍編號'];

        $team_response = $supabaseClient->get('隊伍', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id,
                'select' => '報名進度'
            ]
        ]);
        $members = json_decode($team_response->getBody(), true);


        echo '<h2>歡迎，' . $name . ' 參賽同學！<br>目前狀態: ' . $members[0]['報名進度'] . '</h2>';
        echo '
    <div class="admin-buttons">
        <form action="student_edit.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">修改團隊資訊</button>
        </form>';


        if ($members[0]['報名進度'] != '退件') {
            echo '
        <form action="student_upload.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">上傳作品</button>
        </form>';
        } else {
            echo '
        <form action="student_reregister.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">重新報名</button>
        </form>';
        }


        echo '

        <form action="student_history.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">歷屆作品瀏覽</button>
        </form>
    </div>';
    } else {
        echo '<h2>登入失敗，請返回並重試。</h2>';
        echo '<P>隊伍帳號密碼提示</P>';
        echo '<p>隊伍帳號：隊伍編號</p>';
        echo '<p>隊伍密碼：身分證字號</p>';
        echo '
        <div class="button-container">    
            <a href="student_login.php" class="system-button">返回</a>
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