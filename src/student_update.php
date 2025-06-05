<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改結果 - 高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/student_update.css">
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
        $select_db = @mysqli_select_db($link, "db_project");

        $team_id = $_POST['team_id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $member_count = $_POST['member_count'];

        $success = true;
        $error_messages = [];
        $updated_items = [];

        // 開始交易
        mysqli_autocommit($link, false);

        try {
            // 更新學生資料
            for ($i = 0; $i < $member_count; $i++) {
                if (isset($_POST["student{$i}_id"])) {
                    $student_id = $_POST["student{$i}_id"];
                    $student_num = $_POST["student{$i}_studentid"];
                    $student_name = $_POST["student{$i}_name"];
                    $student_email = $_POST["student{$i}_email"];
                    $student_phone = $_POST["student{$i}_phone"];
                    $student_department = $_POST["student{$i}_department"];
                    $student_grade = $_POST["student{$i}_grade"];

                    $update_sql = "UPDATE 學生 SET 
                                   學號 = ?, 
                                   姓名 = ?, 
                                   電子郵件 = ?, 
                                   電話 = ?, 
                                   科系 = ?, 
                                   年級 = ? 
                                   WHERE 身分證字號 = ? AND 隊伍編號 = ?";
                    
                    $stmt = mysqli_prepare($link, $update_sql);
                    mysqli_stmt_bind_param($stmt, "ssssssss", 
                        $student_num, $student_name, $student_email, 
                        $student_phone, $student_department, $student_grade,
                        $student_id, $team_id);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        $updated_items[] = "學生 " . ($i + 1) . " (" . $student_name . ")";
                    } else {
                        throw new Exception("更新學生 " . ($i + 1) . " 資料失敗");
                    }
                }
            }

            // 更新指導老師資料
            if (isset($_POST['professor_id'])) {
                $professor_id = $_POST['professor_id'];
                $professor_name = $_POST['professor_name'];
                $professor_email = $_POST['professor_email'];
                $professor_phone = $_POST['professor_phone'];

                $update_professor_sql = "UPDATE 指導老師 SET 
                                        姓名 = ?, 
                                        電子郵件 = ?, 
                                        電話 = ? 
                                        WHERE 身分證字號 = ? AND 隊伍編號 = ?";
                
                $stmt = mysqli_prepare($link, $update_professor_sql);
                mysqli_stmt_bind_param($stmt, "sssss", 
                    $professor_name, $professor_email, $professor_phone,
                    $professor_id, $team_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $updated_items[] = "指導老師 (" . $professor_name . ")";
                } else {
                    throw new Exception("更新指導老師資料失敗");
                }
            }

            // 提交交易
            mysqli_commit($link);
            
        } catch (Exception $e) {
            // 回滾交易
            mysqli_rollback($link);
            $success = false;
            $error_messages[] = $e->getMessage();
        }

        // 恢復自動提交
        mysqli_autocommit($link, true);
        ?>

        <div class="result-container">
            <?php if ($success): ?>
                <div class="success-section">
                    <div class="success-icon">✓</div>
                    <h2>資料修改成功！</h2>
                    <div class="success-details">
                        <h3>已更新的資料：</h3>
                        <ul class="updated-list">
                            <?php foreach ($updated_items as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="update-time">更新時間：<?= date('Y-m-d H:i:s') ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="error-section">
                    <div class="error-icon">✗</div>
                    <h2>資料修改失敗</h2>
                    <div class="error-details">
                        <h3>錯誤訊息：</h3>
                        <ul class="error-list">
                            <?php foreach ($error_messages as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <div class="action-buttons">
                <form action="student_edit.php" method="POST" class="inline-form">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                    <button type="submit" class="edit-again-btn">重新修改</button>
                </form>

                <form action="student_dashboard.php" method="POST" class="inline-form">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                    <button type="submit" class="dashboard-btn">返回主頁</button>
                </form>
            </div>
        </div>
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

    <script src="student_update.js"></script>
</body>
</html>
