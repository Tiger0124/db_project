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
    <?php

    if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
        echo '<h2>歡迎，管理員！</h2>';
        echo '
        <div class="admin-buttons">
            <form action="view_students.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢隊伍資料</button>
            </form>
            <form action="view_judges.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查詢評審資料</button>
            </form>
            <form action="view_scores.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">查看評分資料</button>
            </form>
            <form action="announcements.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">公告重要事項</button>
            </form>
            </div>';
    } else {
        echo '<h2>登入失敗，請返回並重試。</h2>';
        echo '
            <div class="button-container">    
                <a href="admin.php" class="system-button">返回</a>
            </div>';
    }
    ?>
</body>
</html>
