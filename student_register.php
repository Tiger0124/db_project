<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽報名系統</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" alt="Logo" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽報名系統</h1>
        </div>
    </header>

    <main id="content">
        <h2>競賽報名表</h2>
        <form action="register_team.php" method="POST">
            <h3>隊伍資料</h3>
            <div class="form-group">
                <label for="team-name">隊伍名稱：</label>
                <input type="text" id="team-name" name="team_name" placeholder="請輸入隊伍名稱" required>
                <!-- 隱藏隊伍編號 -->
                <input type="hidden" name="team_num" value="<?= $team_num ?>">
            </div>

            <h3>學生資料</h3>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="student-info">
                    <h4>學生 <?= $i ?> <?= $i === 4 ? '(選填)' : '' ?></h4>
                    <label for="student<?= $i ?>-id">身分證字號：</label>
                    <input type="text" id="student<?= $i ?>-id" name="student<?= $i ?>_id" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-num">學號：</label>
                    <input type="text" id="student<?= $i ?>-num" name="student<?= $i ?>_num" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-name">姓名：</label>
                    <input type="text" id="student<?= $i ?>-name" name="student<?= $i ?>_name" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-email">電子郵件：</label>
                    <input type="email" id="student<?= $i ?>-email" name="student<?= $i ?>_email" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-phone">電話：</label>
                    <input type="text" id="student<?= $i ?>-phone" name="student<?= $i ?>_phone" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-department">科系：</label>
                    <input type="text" id="student<?= $i ?>-department" name="student<?= $i ?>_department" <?= $i === 4 ? '' : 'required' ?>>
                    
                    <label for="student<?= $i ?>-grade">年級：</label>
                    <input type="text" id="student<?= $i ?>-grade" name="student<?= $i ?>_grade" <?= $i === 4 ? '' : 'required' ?>>
                </div>
            <?php endfor; ?>

            <h3>指導教授資料</h3>
            <div class="form-group">
                <label for="professor-id">身分證字號：</label>
                <input type="text" id="professor-id" name="professor_id" required>
                
                <label for="professor-name">姓名：</label>
                <input type="text" id="professor-name" name="professor_name" required>
                
                <label for="professor-email">電子郵件：</label>
                <input type="email" id="professor-email" name="professor_email" required>
                
                <label for="professor-phone">電話：</label>
                <input type="text" id="professor-phone" name="professor_phone" required>
            </div>

            <button type="submit">提交報名表</button>
        </form>
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
