<?php include 'darkmode.php'; ?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/edit_judge.css">
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

    <main id="content">
        <section class="edit-team-section">
            <h2>修改評審資料</h2>
            <form action="update_judge.php" method="POST">
                <h2 style="margin-left: -70px;">評審資料</h2>

                <!-- 評審資料 -->
                <div class="student-info">
                    <?php
                    include 'conn.php';
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // 發送 GET 請求查詢符合條件的使用者
                    $response = $supabaseClient->get('評審委員', [
                        'query' => [
                            '身分證字號' => 'eq.' . $username,
                            '密碼' => 'eq.' . $password,
                            'select' => '*',
                        ]
                    ]);
                    $data = json_decode($response->getBody(), true);

                    echo '<label for="student1-id">姓名：</label>';
                    echo '<input type="text" id="student1-name" name="student1_name" value="' . $data[0]['姓名'] . '" required>';

                    echo '<label for="student1-name">身分證字號：</label>';
                    echo '<input type="text" id="student1-id" name="student1_id" value="' . $username . '" required readonly>';



                    echo '<label for="student1-email">電子郵件：</label>';
                    echo '<input type="email" id="student1-email" name="student1_email" value="' . $data[0]['電子郵件'] . '" required>';

                    echo '<label for="student1-phone">電話：</label>';
                    echo '<input type="tel" id="student1-phone" name="student1_phone" value="' . $data[0]['電話'] . '" required>';

                    echo '<label for="student1-department">頭銜：</label>';
                    echo '<input type="text" id="student1-department" name="student1_department" value="' . $data[0]['頭銜'] . '" required>';
                    echo '<input type="hidden" id="student1-department" name="student1_session" value="' . $data[0]['屆數'] . '">';
                    ?>

                    <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
                    <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
                    <button type="submit">提交修改</button>
                </div>
            </form>
        </section>

        <form action="judge_dashboard.php" method="POST">
            <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <button type="submit">返回</button>
        </form>
    </main>
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