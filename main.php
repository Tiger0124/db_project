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
    <main id="content">
    <div class="button-container">
        <a href="admin.php" class="system-button">管理員系統</a>
        <a href="student.php" class="system-button">學生系統</a>
        <a href="teacher.php" class="system-button">指導老師系統</a>
        <a href="judge.php" class="system-button">評審系統</a>
    </div>
    <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $file = $page . '.php';
        if (file_exists($file)) {
        include $file;
        } else {
        echo '<h2>歡迎進入創意競賽管理系統</h2><p>請選擇功能。</p>';
        } 
    ?>
    </main>
</body>
</html>
