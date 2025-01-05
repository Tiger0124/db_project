<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改團隊成員資料</title>
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

    <main>
        <?php
            include 'conn.php';
            $select_db = @mysqli_select_db($link, "db_project"); //選擇資料庫
            $filename=$_POST["username"];
            $filepasswd=$_POST["password"];

            $sql = "SELECT * FROM 學生 WHERE  姓名 = '".$filename."' and 身分證字號 = '".$filepasswd."'";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result)==1) {
                echo '<h2>歡迎，'.$filename.'！</h2>';
            } else {
                echo '<h2>登入失敗，請返回並重試。</h2>';
                echo '
                    <div class="button-container">    
                        <a href="student_login.php" class="system-button">返回</a>
                    </div>';
            }
        <section class="edit-team-section">
            <h2>修改團隊成員資料</h2>
            <form action="student_dashboard.php" method="POST">
                <h3>學生資料</h3>

                <!-- 學生 1 資料 -->
                <fieldset>
                    <legend>學生 1</legend>
                    <label for="student1-id">身分證字號：</label>
                    <input type="text" id="student1-id" name="student1_id" value="A123456789" required>

                    <label for="student1-studentid">學號：</label>
                    <input type="text" id="student1-studentid" name="student1_studentid" value="11012345" required>

                    <label for="student1-name">姓名：</label>
                    <input type="text" id="student1-name" name="student1_name" value="王小明" required>

                    <label for="student1-email">電子郵件：</label>
                    <input type="email" id="student1-email" name="student1_email" value="student1@example.com" required>

                    <label for="student1-phone">電話：</label>
                    <input type="tel" id="student1-phone" name="student1_phone" value="0912345678" required>

                    <label for="student1-department">科系：</label>
                    <input type="text" id="student1-department" name="student1_department" value="資訊工程學系" required>

                    <label for="student1-grade">年級：</label>
                    <input type="number" id="student1-grade" name="student1_grade" value="3" required>
                </fieldset>

                <!-- 學生 2 資料 -->
                <fieldset>
                    <legend>學生 2</legend>
                    <label for="student2-id">身分證字號：</label>
                    <input type="text" id="student2-id" name="student2_id" value="B123456789" required>

                    <label for="student2-studentid">學號：</label>
                    <input type="text" id="student2-studentid" name="student2_studentid" value="11012346" required>

                    <label for="student2-name">姓名：</label>
                    <input type="text" id="student2-name" name="student2_name" value="李小華" required>

                    <label for="student2-email">電子郵件：</label>
                    <input type="email" id="student2-email" name="student2_email" value="student2@example.com" required>

                    <label for="student2-phone">電話：</label>
                    <input type="tel" id="student2-phone" name="student2_phone" value="0922345678" required>

                    <label for="student2-department">科系：</label>
                    <input type="text" id="student2-department" name="student2_department" value="機械工程學系" required>

                    <label for="student2-grade">年級：</label>
                    <input type="number" id="student2-grade" name="student2_grade" value="2" required>
                </fieldset>

                <!-- 學生 3 資料 -->
                <fieldset>
                    <legend>學生 3</legend>
                    <label for="student2-id">身分證字號：</label>
                    <input type="text" id="student2-id" name="student2_id" value="B123456789" required>

                    <label for="student2-studentid">學號：</label>
                    <input type="text" id="student2-studentid" name="student2_studentid" value="11012346" required>

                    <label for="student2-name">姓名：</label>
                    <input type="text" id="student2-name" name="student2_name" value="李小華" required>

                    <label for="student2-email">電子郵件：</label>
                    <input type="email" id="student2-email" name="student2_email" value="student2@example.com" required>

                    <label for="student2-phone">電話：</label>
                    <input type="tel" id="student2-phone" name="student2_phone" value="0922345678" required>

                    <label for="student2-department">科系：</label>
                    <input type="text" id="student2-department" name="student2_department" value="機械工程學系" required>

                    <label for="student2-grade">年級：</label>
                    <input type="number" id="student2-grade" name="student2_grade" value="2" required>
                </fieldset>

                <!-- 學生 4 資料 -->
                <fieldset>
                    <legend>學生 4</legend>
                    <label for="student2-id">身分證字號：</label>
                    <input type="text" id="student2-id" name="student2_id" value="B123456789" required>

                    <label for="student2-studentid">學號：</label>
                    <input type="text" id="student2-studentid" name="student2_studentid" value="11012346" required>

                    <label for="student2-name">姓名：</label>
                    <input type="text" id="student2-name" name="student2_name" value="李小華" required>

                    <label for="student2-email">電子郵件：</label>
                    <input type="email" id="student2-email" name="student2_email" value="student2@example.com" required>

                    <label for="student2-phone">電話：</label>
                    <input type="tel" id="student2-phone" name="student2_phone" value="0922345678" required>

                    <label for="student2-department">科系：</label>
                    <input type="text" id="student2-department" name="student2_department" value="機械工程學系" required>

                    <label for="student2-grade">年級：</label>
                    <input type="number" id="student2-grade" name="student2_grade" value="2" required>
                </fieldset>

                <h3>指導教授資料</h3>
                <fieldset>
                    <legend>指導教授</legend>
                    <label for="professor-id">身分證字號：</label>
                    <input type="text" id="professor-id" name="professor_id" value="C123456789" required>

                    <label for="professor-name">姓名：</label>
                    <input type="text" id="professor-name" name="professor_name" value="陳教授" required>

                    <label for="professor-email">電子郵件：</label>
                    <input type="email" id="professor-email" name="professor_email" value="professor@example.com" required>

                    <label for="professor-phone">電話：</label>
                    <input type="tel" id="professor-phone" name="professor_phone" value="0987654321" required>
                </fieldset>
                
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
                <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
                <button type="submit">提交修改</button>
            </form>
            <form action="student_dashboard.php" method="POST">
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
                <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
                <button type="submit">返回</button>
            </form>
        </section>
    </main>
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
