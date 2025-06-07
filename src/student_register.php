<?php include 'darkmode.php'; ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽報名系統</title>
    <link rel="stylesheet" href="../asset/student_register.css">
</head>

<body>
    <header>
        <div class="navbar">
            <a href="main.php" alt="Logo" class="logo">
                <img src="../images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽報名系統</h1>
        </div>
    </header>

    <main id="content">
        <h2>競賽報名表</h2>
        <form action="register_team.php" method="POST" id="registrationForm">
            <h3>隊伍資料</h3>
            <div class="form-group">
                <label for="team-name">隊伍名稱：</label>
                <input type="text" id="team-name" name="team_name" placeholder="請輸入隊伍名稱" required>
                <input type="hidden" name="team_num" value="<?= isset($team_num) ? $team_num : 'T001' ?>">
            </div>

            <div class="student-section">
                <div class="section-header">
                    <h3>學生資料</h3>
                    <div class="member-buttons">
                        <button type="button" class="member-btn active" data-member="1">組員一</button>
                        <button type="button" class="member-btn" data-member="2">組員二</button>
                        <button type="button" class="member-btn" data-member="3">組員三</button>
                        <button type="button" class="member-btn optional" data-member="4">組員四 (選填)</button>
                    </div>
                </div>

                <div id="studentsContainer">
                    <!-- 組員一表單 -->
                    <div class="student-info active" data-student="1">
                        <div class="student-header">
                            <h4>組員一資料</h4>
                            <span class="required-badge">必填</span>
                        </div>

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

                    </div>

                    <!-- 組員二表單 -->
                    <div class="student-info" data-student="2" style="display: none;">
                        <div class="student-header">
                            <h4>組員二資料</h4>
                            <span class="required-badge">必填</span>
                        </div>

                        <label for="student2-id">身分證字號：</label>
                        <input type="text" id="student2-id" name="student2_id">

                        <label for="student2-num">學號：</label>
                        <input type="text" id="student2-num" name="student2_num">

                        <label for="student2-name">姓名：</label>
                        <input type="text" id="student2-name" name="student2_name">

                        <label for="student2-email">電子郵件：</label>
                        <input type="email" id="student2-email" name="student2_email">

                        <label for="student2-phone">電話：</label>
                        <input type="text" id="student2-phone" name="student2_phone">

                        <label for="student2-department">科系：</label>
                        <input type="text" id="student2-department" name="student2_department">

                    </div>

                    <!-- 組員三表單 -->
                    <div class="student-info" data-student="3" style="display: none;">
                        <div class="student-header">
                            <h4>組員三資料</h4>
                            <span class="required-badge">必填</span>
                        </div>

                        <label for="student3-id">身分證字號：</label>
                        <input type="text" id="student3-id" name="student3_id">

                        <label for="student3-num">學號：</label>
                        <input type="text" id="student3-num" name="student3_num">

                        <label for="student3-name">姓名：</label>
                        <input type="text" id="student3-name" name="student3_name">

                        <label for="student3-email">電子郵件：</label>
                        <input type="email" id="student3-email" name="student3_email">

                        <label for="student3-phone">電話：</label>
                        <input type="text" id="student3-phone" name="student3_phone">

                        <label for="student3-department">科系：</label>
                        <input type="text" id="student3-department" name="student3_department">

                    </div>

                    <!-- 組員四表單 (選填) -->
                    <div class="student-info optional-member" data-student="4" style="display: none;">
                        <div class="student-header">
                            <h4>組員四資料</h4>
                            <span class="optional-badge">選填</span>
                        </div>

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

                    </div>
                </div>
            </div>

            <h3>指導教授資料</h3>
            <div class="form-group">
                <label for="professor-name">姓名：</label>
                <select id="professor-name" name="professor_name" required onchange="fetchProfessorInfo()">
                    <option value="">請選擇指導老師姓名</option>
                    <?php
                    include 'conn.php';

                    // 從 Supabase 撈取教授資料
                    $response = $supabaseClient->get("指導老師"); // 假設表名為「教授」
                    $professors = json_decode($response->getBody(), true);

                    foreach ($professors as $professor) {
                        $name = $professor['姓名']; // 根據你的資料欄位名稱調整
                        echo "<option value=\"" . htmlspecialchars($name) . "\">$name</option>";
                    }
                    ?>
                </select>

                <label for="professor-jobtitle">職稱：</label>
                <input type="text" id="professor-jobtitle" name="professor_jobtitle" required readonly>

                <label for="professor-email">電子郵件：</label>
                <input type="email" id="professor-email" name="professor_email" required readonly>

                <label for="professor-phone">電話：</label>
                <input type="text" id="professor-phone" name="professor_phone" required readonly>

                <input type="hidden" id="professor-id" name="professor_id">
            </div>

            <div class="submit-section">
                <button type="submit" id="submitBtn">提交報名表</button>
            </div>
        </form>
        
        <div class="return-section">
            <form action="student_dashboard.php" method="POST">
                <input type="hidden" name="username" value="<?= htmlspecialchars($_POST['username']) ?>">
                <input type="hidden" name="password" value="<?= htmlspecialchars($_POST['password']) ?>">
                <button type="submit" class="return-btn">返回</button>
            </form>
        </div>
    </main>

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

    <script src="student_register.js"></script>
    <script>
    function fetchProfessorInfo() {
        const name = document.getElementById('professor-name').value;

        if (name === "") {
            document.getElementById('professor-jobtitle').value = "";
            document.getElementById('professor-email').value = "";
            document.getElementById('professor-phone').value = "";
            document.getElementById('professor-id').value = "";
            return;
        }

        fetch('get_teacher_info.php?name=' + encodeURIComponent(name))
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    alert("找不到該教授");
                    return;
                }

                if (data.length === 1) {
                    document.getElementById('professor-jobtitle').value = data[0].jobtitle || '';
                    document.getElementById('professor-email').value = data[0].email || '';
                    document.getElementById('professor-phone').value = data[0].phone || '';
                    document.getElementById('professor-id').value = data[0].id || '';
                } else {
                    // 多筆 → 讓使用者挑選
                    const selected = prompt("找到多位同名指導老師，請輸入要選哪一位的序號：\n" +
                        data.map((prof, i) =>
                            `${i + 1}. 電子郵件: ${prof.email}，電話: ${prof.phone} 職稱: ${prof.jobtitle} 身分證字號: ${prof.id}`
                        ).join("\n"));

                    const idx = parseInt(selected) - 1;
                    if (!isNaN(idx) && idx >= 0 && idx < data.length) {
                        document.getElementById('professor-email').value = data[idx].email || '';
                        document.getElementById('professor-phone').value = data[idx].phone || '';
                        document.getElementById('professor-jobtitle').value = data[idx].jobtitle || '';
                        document.getElementById('professor-id').value = data[idx].id || '';
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching professor info:', error);
            });
    }
    </script>
</body>

</html>