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
        <h2 style="text-align: center">學生登入系統 </h2> 
        <form action="student_dashboard.php" method="POST">
            <label for="username">用戶名</label>
            <input type="text" id="username" name="username" required>
            <label for="password">密碼</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">登入</button>
        </form>
    </main>
</body>