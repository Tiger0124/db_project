<?php include 'darkmode.php'; ?>

<?php
// 在 HTML 渲染之前，先執行所有資料庫操作
include 'conn.php'; // 引入您的 Supabase 連線設定

// --- 資料初始化 ---
// 先定義好所有可能會用到的變數，避免未定義的錯誤
$team_id = '';
$team_data = [];
$members = [];
$professor = [];

// --- 資料擷取 ---
// 只有在表單是透過 POST 方法提交時才嘗試讀取資料 (例如從登入頁面跳轉而來)
// 這可以避免在直接瀏覽此頁面時出現錯誤
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"]) && isset($_POST["password"])) {
    $login_user_id = $_POST["username"];
    $login_user_passwd = $_POST["password"];

    // 1. 驗證使用者並取得其隊伍編號
    $user_response = $supabaseClient->get('學生', [
        'query' => [
            '學號' => 'eq.' . $login_user_id,
            '身分證字號' => 'eq.' . $login_user_passwd,
            'select' => '隊伍編號', // 只需要隊伍編號
        ]
    ]);
    $user_data = json_decode($user_response->getBody(), true);

    // 如果成功找到使用者，且他有關聯的隊伍
    if (count($user_data) === 1 && !empty($user_data[0]['隊伍編號'])) {
        $team_id = $user_data[0]['隊伍編號'];

        // 2. 取得隊伍資料 (隊伍名稱)
        $team_response = $supabaseClient->get('隊伍', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id,
                'select' => '隊伍名稱'
            ]
        ]);
        $team_result = json_decode($team_response->getBody(), true);
        if (count($team_result) > 0) {
            $team_data = $team_result[0];
        }

        // 3. 取得所有隊伍成員的詳細資料
        $members_response = $supabaseClient->get('學生', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id,
                'select' => '身分證字號,學號,姓名,電子郵件,電話,科系',
                'order' => '學號' // 確保組員順序一致
            ]
        ]);
        $members = json_decode($members_response->getBody(), true);

        // 4. 取得指導老師的資料
        $professor_response = $supabaseClient->get('指導老師', [
            'query' => [
                '隊伍編號' => 'eq.' . $team_id,
                'select' => '身分證字號,姓名,電子郵件,電話'
            ]
        ]);
        $professor_result = json_decode($professor_response->getBody(), true);
        if (count($professor_result) > 0) {
            $professor = $professor_result[0];
        }
    }
}
?>
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
                <input type="text" id="team-name" name="team_name" placeholder="請輸入隊伍名稱"
                    value="<?= htmlspecialchars($team_data['隊伍名稱'] ?? '') ?>" required>
                <input type="hidden" name="team_num" value="<?= htmlspecialchars($team_id) ?>">
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
                    <div class="student-info active" data-student="1">
                        <div class="student-header">
                            <h4>組員一資料</h4>
                            <span class="required-badge">必填</span>
                        </div>
                        <label for="student1-id">身分證字號：</label>
                        <input type="text" id="student1-id" name="student1_id"
                            value="<?= htmlspecialchars($members[0]['身分證字號'] ?? '') ?>" required>
                        <label for="student1-num">學號：</label>
                        <input type="text" id="student1-num" name="student1_num"
                            value="<?= htmlspecialchars($members[0]['學號'] ?? '') ?>" required>
                        <label for="student1-name">姓名：</label>
                        <input type="text" id="student1-name" name="student1_name"
                            value="<?= htmlspecialchars($members[0]['姓名'] ?? '') ?>" required>
                        <label for="student1-email">電子郵件：</label>
                        <input type="email" id="student1-email" name="student1_email"
                            value="<?= htmlspecialchars($members[0]['電子郵件'] ?? '') ?>" required>
                        <label for="student1-phone">電話：</label>
                        <input type="text" id="student1-phone" name="student1_phone"
                            value="<?= htmlspecialchars($members[0]['電話'] ?? '') ?>" required>
                        <label for="student1-department">科系：</label>
                        <input type="text" id="student1-department" name="student1_department"
                            value="<?= htmlspecialchars($members[0]['科系'] ?? '') ?>" required>
                    </div>

                    <div class="student-info" data-student="2" style="display: none;">
                        <div class="student-header">
                            <h4>組員二資料</h4>
                            <span class="required-badge">必填</span>
                        </div>
                        <label for="student2-id">身分證字號：</label>
                        <input type="text" id="student2-id" name="student2_id"
                            value="<?= htmlspecialchars($members[1]['身分證字號'] ?? '') ?>" required>
                        <label for="student2-num">學號：</label>
                        <input type="text" id="student2-num" name="student2_num"
                            value="<?= htmlspecialchars($members[1]['學號'] ?? '') ?>" required>
                        <label for="student2-name">姓名：</label>
                        <input type="text" id="student2-name" name="student2_name"
                            value="<?= htmlspecialchars($members[1]['姓名'] ?? '') ?>" required>
                        <label for="student2-email">電子郵件：</label>
                        <input type="email" id="student2-email" name="student2_email"
                            value="<?= htmlspecialchars($members[1]['電子郵件'] ?? '') ?>" required>
                        <label for="student2-phone">電話：</label>
                        <input type="text" id="student2-phone" name="student2_phone"
                            value="<?= htmlspecialchars($members[1]['電話'] ?? '') ?>" required>
                        <label for="student2-department">科系：</label>
                        <input type="text" id="student2-department" name="student2_department"
                            value="<?= htmlspecialchars($members[1]['科系'] ?? '') ?>" required>
                    </div>

                    <div class="student-info" data-student="3" style="display: none;">
                        <div class="student-header">
                            <h4>組員三資料</h4>
                            <span class="required-badge">必填</span>
                        </div>
                        <label for="student3-id">身分證字號：</label>
                        <input type="text" id="student3-id" name="student3_id"
                            value="<?= htmlspecialchars($members[2]['身分證字號'] ?? '') ?>" required>
                        <label for="student3-num">學號：</label>
                        <input type="text" id="student3-num" name="student3_num"
                            value="<?= htmlspecialchars($members[2]['學號'] ?? '') ?>" required>
                        <label for="student3-name">姓名：</label>
                        <input type="text" id="student3-name" name="student3_name"
                            value="<?= htmlspecialchars($members[2]['姓名'] ?? '') ?>" required>
                        <label for="student3-email">電子郵件：</label>
                        <input type="email" id="student3-email" name="student3_email"
                            value="<?= htmlspecialchars($members[2]['電子郵件'] ?? '') ?>" required>
                        <label for="student3-phone">電話：</label>
                        <input type="text" id="student3-phone" name="student3_phone"
                            value="<?= htmlspecialchars($members[2]['電話'] ?? '') ?>" required>
                        <label for="student3-department">科系：</label>
                        <input type="text" id="student3-department" name="student3_department"
                            value="<?= htmlspecialchars($members[2]['科系'] ?? '') ?>" required>
                    </div>

                    <div class="student-info optional-member" data-student="4" style="display: none;">
                        <div class="student-header">
                            <h4>組員四資料</h4>
                            <span class="optional-badge">選填</span>
                        </div>
                        <label for="student4-id">身分證字號：</label>
                        <input type="text" id="student4-id" name="student4_id"
                            value="<?= htmlspecialchars($members[3]['身分證字號'] ?? '') ?>">
                        <label for="student4-num">學號：</label>
                        <input type="text" id="student4-num" name="student4_num"
                            value="<?= htmlspecialchars($members[3]['學號'] ?? '') ?>">
                        <label for="student4-name">姓名：</label>
                        <input type="text" id="student4-name" name="student4_name"
                            value="<?= htmlspecialchars($members[3]['姓名'] ?? '') ?>">
                        <label for="student4-email">電子郵件：</label>
                        <input type="email" id="student4-email" name="student4_email"
                            value="<?= htmlspecialchars($members[3]['電子郵件'] ?? '') ?>">
                        <label for="student4-phone">電話：</label>
                        <input type="text" id="student4-phone" name="student4_phone"
                            value="<?= htmlspecialchars($members[3]['電話'] ?? '') ?>">
                        <label for="student4-department">科系：</label>
                        <input type="text" id="student4-department" name="student4_department"
                            value="<?= htmlspecialchars($members[3]['科系'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <h3>指導教授資料</h3>
            <div class="form-group">
                <label for="professor-id">身分證字號：</label>
                <input type="text" id="professor-id" name="professor_id"
                    value="<?= htmlspecialchars($professor['身分證字號'] ?? '') ?>" required>
                <label for="professor-name">姓名：</label>
                <input type="text" id="professor-name" name="professor_name"
                    value="<?= htmlspecialchars($professor['姓名'] ?? '') ?>" required>
                <label for="professor-email">電子郵件：</label>
                <input type="email" id="professor-email" name="professor_email"
                    value="<?= htmlspecialchars($professor['電子郵件'] ?? '') ?>" required>
                <label for="professor-phone">電話：</label>
                <input type="text" id="professor-phone" name="professor_phone"
                    value="<?= htmlspecialchars($professor['電話'] ?? '') ?>" required>
            </div>

            <div class="submit-section">
                <button type="submit" id="submitBtn">提交報名表</button>
            </div>
        </form>
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
</body>

</html>