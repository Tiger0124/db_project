<?php include 'darkmode.php'; ?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改團隊成員資料</title>
    <link rel="stylesheet" href="../asset/student_edit.css">
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
        <?php
        include 'conn.php';
        $filename = $_POST["username"];
        $filepasswd = $_POST["password"];

        // 驗證使用者身份
        $response = $supabaseClient->get('學生', [
            'query' => [
                '學號' => 'eq.' . $filename,
                '身分證字號' => 'eq.' . $filepasswd,
                'select' => '*',
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        if (count($data) == 1) {
            $row = $data[0];
            echo '<h2>歡迎，' . htmlspecialchars($filename) . '！</h2>';

            // 取得隊伍編號
            $team_id = $row['隊伍編號'];

            // 取得隊伍成員資料
            $team_response = $supabaseClient->get('學生', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id,
                    'select' => '身分證字號,學號,姓名,電子郵件,電話,科系',
                    'order' => '學號'
                ]
            ]);
            $members = json_decode($team_response->getBody(), true);
        ?>
            <section class="edit-team-section">
                <h2>修改團隊成員資料</h2>

                <!-- 學生資料切換按鈕 -->
                <div class="member-tabs">
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $index => $member): ?>
                            <button type="button" class="tab-btn <?= $index === 0 ? 'active' : '' ?>" data-member="<?= $index ?>">
                                學生 <?= $index + 1 ?>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <form action="student_update.php" method="POST" id="editForm">
                    <!-- 學生資料表單 -->
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $index => $member): ?>
                            <div class="member-form <?= $index === 0 ? 'active' : '' ?>" data-form="<?= $index ?>">
                                <fieldset class="student-fieldset">
                                    <legend>學生 <?= $index + 1 ?> 資料</legend>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-id">身分證字號：</label>
                                            <input type="text" id="student<?= $index ?>-id" name="student<?= $index ?>_id"
                                                value="<?= htmlspecialchars($member["身分證字號"]) ?>" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-studentid">學號：</label>
                                            <input type="text" id="student<?= $index ?>-studentid"
                                                name="student<?= $index ?>_studentid" value="<?= htmlspecialchars($member["學號"]) ?>"
                                                required readonly>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-name">姓名：</label>
                                            <input type="text" id="student<?= $index ?>-name" name="student<?= $index ?>_name"
                                                value="<?= htmlspecialchars($member["姓名"]) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-email">電子郵件：</label>
                                            <input type="text" id="student<?= $index ?>-email" name="student<?= $index ?>_email"
                                                value="<?= htmlspecialchars($member["電子郵件"]) ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-phone">電話：</label>
                                            <input type="text" id="student<?= $index ?>-phone" name="student<?= $index ?>_phone"
                                                value="<?= htmlspecialchars($member["電話"]) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student<?= $index ?>-department">科系：</label>
                                            <input type="text" id="student<?= $index ?>-department"
                                                name="student<?= $index ?>_department"
                                                value="<?= htmlspecialchars($member["科系"]) ?>" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <input type="hidden" name="team_id" value="<?= $team_id ?>">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($_POST['username']) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($_POST['password']) ?>">
                    <input type="hidden" name="member_count" value="<?= count($members) ?>">

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">提交修改</button>
                    </div>
                </form>

                <div class="return-section">
                    <form action="student_dashboard.php" method="POST">
                        <input type="hidden" name="username" value="<?= htmlspecialchars($_POST['username']) ?>">
                        <input type="hidden" name="password" value="<?= htmlspecialchars($_POST['password']) ?>">
                        <button type="submit" class="return-btn">返回</button>
                    </form>
                </div>
            </section>

        <?php
        } else {
            echo '<div class="error-section">';
            echo '<h2>登入失敗，請返回並重試。</h2>';
            echo '<div class="button-container">';
            echo '<a href="student_login.php" class="system-button">返回登入</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
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

    <script src="student_edit.js"></script>
</body>

</html>