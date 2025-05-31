<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改團隊成員資料</title>
    <link rel="stylesheet" href="student_edit.css">
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
        <?php
            include 'conn.php';
            $select_db = @mysqli_select_db($link, "db_project"); // 選擇資料庫
            $filename = $_POST["username"];
            $filepasswd = $_POST["password"];

            // 驗證使用者身份
            $sql = "SELECT * FROM 學生 WHERE 隊伍編號 = ? AND 身分證字號 = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $filename, $filepasswd);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                echo '<h2>歡迎，' . htmlspecialchars($filename) . '！</h2>';

                // 取得隊伍編號
                $row = mysqli_fetch_assoc($result);
                $team_id = $row['隊伍編號'];

                // 取得隊伍成員資料
                $team_sql = "
                    SELECT 身分證字號, 學號, 姓名, 電子郵件, 電話, 科系, 年級
                    FROM 學生
                    WHERE 隊伍編號 = ?";
                $team_stmt = mysqli_prepare($link, $team_sql);
                mysqli_stmt_bind_param($team_stmt, "s", $team_id);
                mysqli_stmt_execute($team_stmt);
                $team_result = mysqli_stmt_get_result($team_stmt);
                $members = mysqli_fetch_all($team_result, MYSQLI_ASSOC);

                // 取得指導老師資料
                $professor_sql = "
                    SELECT 身分證字號, 姓名, 電子郵件, 電話
                    FROM 指導老師
                    WHERE 隊伍編號 = ?";
                $professor_stmt = mysqli_prepare($link, $professor_sql);
                mysqli_stmt_bind_param($professor_stmt, "s", $team_id);
                mysqli_stmt_execute($professor_stmt);
                $professor_result = mysqli_stmt_get_result($professor_stmt);
                $professor = mysqli_fetch_assoc($professor_result);
            } else {
                echo '<h2>登入失敗，請返回並重試。</h2>';
                echo '
                    <div class="button-container">    
                        <a href="student_login.php" class="system-button">返回</a>
                    </div>';
                exit; // 結束執行，避免顯示後續內容
            }
        ?>

        <section class="edit-team-section">
            <h2>修改團隊成員資料</h2>
            <form action="student_update.php" method="POST">
                <?php
                // 動態生成學生資料表單
                if (!empty($members)) {
                    foreach ($members as $index => $member) {
                        echo '
                            <fieldset>
                                <legend>學生 ' . ($index + 1) . '</legend>
                                <label for="student' . $index . '-id">身分證字號：</label>
                                <input type="text" id="student' . $index . '-id" name="student' . $index . '_id" value="' . htmlspecialchars($member["身分證字號"]) . '" required>

                                <label for="student' . $index . '-studentid">學號：</label>
                                <input type="text" id="student' . $index . '-studentid" name="student' . $index . '_studentid" value="' . htmlspecialchars($member["學號"]) . '" required>

                                <label for="student' . $index . '-name">姓名：</label>
                                <input type="text" id="student' . $index . '-name" name="student' . $index . '_name" value="' . htmlspecialchars($member["姓名"]) . '" required>

                                <label for="student' . $index . '-email">電子郵件：</label>
                                <input type="email" id="student' . $index . '-email" name="student' . $index . '_email" value="' . htmlspecialchars($member["電子郵件"]) . '" required>

                                <label for="student' . $index . '-phone">電話：</label>
                                <input type="tel" id="student' . $index . '-phone" name="student' . $index . '_phone" value="' . htmlspecialchars($member["電話"]) . '" required>

                                <label for="student' . $index . '-department">科系：</label>
                                <input type="text" id="student' . $index . '-department" name="student' . $index . '_department" value="' . htmlspecialchars($member["科系"]) . '" required>

                                <label for="student' . $index . '-grade">年級：</label>
                                <input type="number" id="student' . $index . '-grade" name="student' . $index . '_grade" value="' . htmlspecialchars($member["年級"]) . '" required>
                            </fieldset>
                        ';
                    }
                } else {
                    echo "<p>無法取得隊伍成員資料。</p>";
                }

                // 動態生成指導老師表單
                if (!empty($professor)) {
                    echo '
                        <h3>指導老師資料</h3>
                        <fieldset>
                            <legend>指導老師</legend>
                            <label for="professor-id">身分證字號：</label>
                            <input type="text" id="professor-id" name="professor_id" value="' . htmlspecialchars($professor["身分證字號"]) . '" required>

                            <label for="professor-name">姓名：</label>
                            <input type="text" id="professor-name" name="professor_name" value="' . htmlspecialchars($professor["姓名"]) . '" required>

                            <label for="professor-email">電子郵件：</label>
                            <input type="email" id="professor-email" name="professor_email" value="' . htmlspecialchars($professor["電子郵件"]) . '" required>

                            <label for="professor-phone">電話：</label>
                            <input type="tel" id="professor-phone" name="professor_phone" value="' . htmlspecialchars($professor["電話"]) . '" required>
                        </fieldset>
                    ';
                } else {
                    echo "<p>無法取得指導老師資料。</p>";
                }
                ?>
                <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
                <button type="submit">提交修改</button>
            </form>

            <form action="student_dashboard.php" method="POST">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
                <button type="submit">返回</button>
            </form>
        </section>
    </main>

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
</body>
</html>
