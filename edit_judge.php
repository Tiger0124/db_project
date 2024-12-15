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
        <section class="edit-team-section">
            <h2>修改評審資料</h2>
            <form action="judge_dashboard.php" method="POST">
                <h3>評審資料</h3>

                <!-- 學生 1 資料 -->
                <fieldset>
                    <legend>xx 評審</legend>
                    <label for="student1-id">身分證字號：</label>
                    <input type="text" id="student1-id" name="student1_id" value="A123456789" required>

                    <label for="student1-name">姓名：</label>
                    <input type="text" id="student1-name" name="student1_name" value="王小明" required>

                    <label for="student1-email">電子郵件：</label>
                    <input type="email" id="student1-email" name="student1_email" value="student1@example.com" required>

                    <label for="student1-phone">電話：</label>
                    <input type="tel" id="student1-phone" name="student1_phone" value="0912345678" required>

                    <label for="student1-department">頭銜：</label>
                    <input type="text" id="student1-department" name="student1_department" value="老師" required>
                </fieldset>
                
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
                <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
                <button type="submit">提交修改</button>
            </form>
        </section>
    
    <form action="judge_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
    </main>
</body>
</html>
