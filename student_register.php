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

    
        
            <h2>競賽報名表</h2>
            <form action="register_team.php" method="POST">
                <h3>隊伍資料</h3>
                <div class="form-group">
                    <label for="team-name">隊伍名稱：</label>
                    <input type="text" id="team-name" name="team_name" placeholder="請輸入隊伍名稱" required>
                </div>

                <h3>學生資料</h3>
                <!-- 學生1 -->
                <div class="student-info">
                    <h4>學生 1</h4>
                    <label for="student1-id">身分證字號：</label>
                    <input type="text" id="student1-id" name="student1_id" required>
                    
                    <label for="student1-num">學號：</label>
                    <input type="text" id="student1-num" name="student1_num" required>
                    
                    <label for="student1-name">姓名：</label>
                    <input type="text" id="student1-name" name="student1_name" required>
                    
                    <label for="student1-email">電子郵件：</label>
                    <input type="email" id="student1-email" name="student1_email" required>
                    
                    <label for="student1-phone">電話：</label>
                    <input type="text" id="student1-phone" name="student1_phone" required>
                    
                    <label for="student1-department">科系：</label>
                    <input type="text" id="student1-department" name="student1_department" required>
                    
                    <label for="student1-grade">年級：</label>
                    <input type="text" id="student1-grade" name="student1_grade" required>
                </div>

                <!-- 學生2 -->
                <div class="student-info">
                    <h4>學生 2</h4>
                    <label for="student2-id">身分證字號：</label>
                    <input type="text" id="student2-id" name="student2_id" required>
                    
                    <label for="student2-num">學號：</label>
                    <input type="text" id="student2-num" name="student2_num" required>
                    
                    <label for="student2-name">姓名：</label>
                    <input type="text" id="student2-name" name="student2_name" required>
                    
                    <label for="student2-email">電子郵件：</label>
                    <input type="email" id="student2-email" name="student2_email" required>
                    
                    <label for="student2-phone">電話：</label>
                    <input type="text" id="student2-phone" name="student2_phone" required>
                    
                    <label for="student2-department">科系：</label>
                    <input type="text" id="student2-department" name="student2_department" required>
                    
                    <label for="student2-grade">年級：</label>
                    <input type="text" id="student2-grade" name="student2_grade" required>
                </div>

                <!-- 學生3 -->
                <div class="student-info">
                    <h4>學生 3</h4>
                    <label for="student3-id">身分證字號：</label>
                    <input type="text" id="student3-id" name="student3_id" required>
                    
                    <label for="student3-num">學號：</label>
                    <input type="text" id="student3-num" name="student3_num" required>
                    
                    <label for="student3-name">姓名：</label>
                    <input type="text" id="student3-name" name="student3_name" required>
                    
                    <label for="student3-email">電子郵件：</label>
                    <input type="email" id="student3-email" name="student3_email" required>
                    
                    <label for="student3-phone">電話：</label>
                    <input type="text" id="student3-phone" name="student3_phone" required>
                    
                    <label for="student3-department">科系：</label>
                    <input type="text" id="student3-department" name="student3_department" required>
                    
                    <label for="student3-grade">年級：</label>
                    <input type="text" id="student3-grade" name="student3_grade" required>
                </div>

                <!-- 學生4（選填） -->
                <div class="student-info">
                    <h4>學生 4 (選填)</h4>
                    <label for="student4-id">身分證字號：</label>
                    <input type="text" id="student4-id" name="student4_id">
                    
                    <label for="student4-num">學號：</label>
                    <input type="text" id="student4-num" name="student4_num">
                    
                    <label for="student4-name">姓名：</label>
                    <input type="text" id="student4-name" name="student4_name">
                    
                    <label for="student4-email">電子郵件：</label>
                    <input type="email" id="student4-email" name="student4_email">
                    
                    <label for="student4-phone">電話：</label>
                    <input type="text" id="student4-phone" name="student4_phone">
                    
                    <label for="student4-department">科系：</label>
                    <input type="text" id="student4-department" name="student4_department">
                    
                    <label for="student4-grade">年級：</label>
                    <input type="text" id="student4-grade" name="student4_grade">
                </div>

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
        
    
</body>
</html>
