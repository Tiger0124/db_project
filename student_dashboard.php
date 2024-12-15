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
        echo '<h2>歡迎，組名！</h2>';
        echo '
        <main id="content">
            <div class="rounded-box">
                <div class="button-container">
                    <a href="student_info.php" class="system-button">修改團隊資訊</a>
                    <a href="student_sign_up.php" class="system-button">報名系統</a>
                    <a href="student_history.php" class="system-button">歷屆作品瀏覽</a>
                </div>
            </div>
        </main>';
    } else {
        echo '<p>登入失敗，請返回並重試。</p>';
        echo '<a href="student_login.php">返回</a>';
    }
    ?>
</body>
</html>
