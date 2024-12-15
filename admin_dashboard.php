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
            <img src="images/logo.png" alt="Logo" class="logo">
            <h1>高雄大學激發學生創意競賽管理系統</h1>
            </div>
        </header>
        <?php
            if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
                echo '<h2>歡迎，管理員！</h2>';
                //echo '<p>請選擇以下功能：</p>';
                echo '
                <div class="rounded-box">
                    <div class="button-container">
                        <a href="view_students.php" class="system-button">查詢學生資料</a>
                        <a href="edit_students.php" class="system-button">修改報名資料</a>
                        <a href="view_judges.php" class="system-button">查詢評審資料</a>
                        <a href="view_scores.php" class="system-button">查看評分資料</a>
                        <a href="announcements.php" class="system-button">公告重要事項</a>
                    </div>
                </div>';
            } else {
                echo '<p>登入失敗，請返回並重試。</p>';
                echo '<a href="index.php?page=admin">返回</a>';
            }
        ?>

    </body>

