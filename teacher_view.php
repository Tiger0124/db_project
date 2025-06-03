<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師指導隊伍資料</title>
    <link rel="stylesheet" href="teacher_view.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main>
        <?php
        include 'conn.php';
        $select_db = @mysqli_select_db($link, "db_project");
        
        $filename = $_POST["username"];
        $filepasswd = $_POST["password"];

        // 使用 Prepared Statement 查詢指導老師資料
        $sql = "SELECT * FROM 指導老師 WHERE 隊伍編號 = ? AND 身分證字號 = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $filename, $filepasswd);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $team_id = $row['隊伍編號'];

            // 取得隊伍和作品資料
            $team_sql = "
            SELECT 隊伍.隊伍編號, 說明書, 作品展示_youtube連結, 程式碼_Github連結, 隊伍名稱
            FROM 作品 JOIN 隊伍 ON 作品.隊伍編號 = 隊伍.隊伍編號
            WHERE 隊伍.隊伍編號 = ?";

            $team_stmt = mysqli_prepare($link, $team_sql);
            mysqli_stmt_bind_param($team_stmt, "s", $team_id);
            mysqli_stmt_execute($team_stmt);
            $team_result = mysqli_stmt_get_result($team_stmt);
            
            if (mysqli_num_rows($team_result) > 0) {
                echo "<section class='team-info'>";
                echo "<h2>指導的隊伍資訊</h2>";
                
                // 顯示隊伍資料
                $team_row = mysqli_fetch_assoc($team_result);
                $blob = base64_encode($team_row['說明書']);
                
                echo "<div class='team-details'>";
                echo "<div class='team-basic-info'>";
                echo "<h3>隊伍基本資料</h3>";
                echo "<div class='info-item'>";
                echo "<span class='label'>隊伍名稱：</span>";
                echo "<span class='value'>" . htmlspecialchars($team_row['隊伍名稱']) . "</span>";
                echo "</div>";
                echo "<div class='info-item'>";
                echo "<span class='label'>作品說明書：</span>";
                echo "<a href='data:application/pdf;base64," . $blob . "' download class='download-link'>下載說明書</a>";
                echo "</div>";
                echo "<div class='info-item'>";
                echo "<span class='label'>作品影片網址：</span>";
                echo "<a href='" . htmlspecialchars($team_row['作品展示_youtube連結']) . "' target='_blank' class='external-link'>" . htmlspecialchars($team_row['作品展示_youtube連結']) . "</a>";
                echo "</div>";
                echo "<div class='info-item'>";
                echo "<span class='label'>作品程式碼網址：</span>";
                echo "<a href='" . htmlspecialchars($team_row['程式碼_Github連結']) . "' target='_blank' class='external-link'>" . htmlspecialchars($team_row['程式碼_Github連結']) . "</a>";
                echo "</div>";
                echo "</div>";

                // 取得學生資料
                $student_sql = "
                SELECT 身分證字號, 學號, 姓名, 電子郵件, 電話, 科系, 年級
                FROM 學生
                WHERE 隊伍編號 = ?
                ORDER BY 學號";
                
                $student_stmt = mysqli_prepare($link, $student_sql);
                mysqli_stmt_bind_param($student_stmt, "s", $team_id);
                mysqli_stmt_execute($student_stmt);
                $student_result = mysqli_stmt_get_result($student_stmt);
                $students_data = mysqli_fetch_all($student_result, MYSQLI_ASSOC);

                // 顯示學生資料 - 桌面版表格
                echo "<div class='students-section'>";
                echo "<h3>學生資料</h3>";
                echo "<div class='table-container desktop-table'>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>姓名</th>";
                echo "<th>學號</th>";
                echo "<th>身分證字號</th>";
                echo "<th>科系</th>";
                echo "<th>年級</th>";
                echo "<th>電子郵件</th>";
                echo "<th>電話</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                foreach ($students_data as $student) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student['姓名']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['學號']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['身分證字號']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['科系']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['年級']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['電子郵件']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['電話']) . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
                echo "</div>";

                // 手機版卡片顯示
                echo "<div class='mobile-cards'>";
                foreach ($students_data as $index => $student) {
                    echo "<div class='student-card'>";
                    echo "<div class='card-header'>";
                    echo "<h4>學生 " . ($index + 1) . "</h4>";
                    echo "</div>";
                    echo "<div class='card-body'>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>姓名：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['姓名']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>學號：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['學號']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>身分證字號：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['身分證字號']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>科系：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['科系']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>年級：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['年級']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>電子郵件：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['電子郵件']) . "</span>";
                    echo "</div>";
                    echo "<div class='card-field'>";
                    echo "<span class='field-label'>電話：</span>";
                    echo "<span class='field-value'>" . htmlspecialchars($student['電話']) . "</span>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";

                // 顯示指導教授資料
                echo "<div class='professor-section'>";
                echo "<h3>指導教授資料</h3>";
                echo "<div class='table-container desktop-table'>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>姓名</th>";
                echo "<th>身分證字號</th>";
                echo "<th>電子郵件</th>";
                echo "<th>電話</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['姓名']) . "</td>";
                echo "<td>" . htmlspecialchars($row['身分證字號']) . "</td>";
                echo "<td>" . htmlspecialchars($row['電子郵件']) . "</td>";
                echo "<td>" . htmlspecialchars($row['電話']) . "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>";

                // 手機版教授卡片
                echo "<div class='mobile-cards'>";
                echo "<div class='professor-card'>";
                echo "<div class='card-header'>";
                echo "<h4>指導教授</h4>";
                echo "</div>";
                echo "<div class='card-body'>";
                echo "<div class='card-field'>";
                echo "<span class='field-label'>姓名：</span>";
                echo "<span class='field-value'>" . htmlspecialchars($row['姓名']) . "</span>";
                echo "</div>";
                echo "<div class='card-field'>";
                echo "<span class='field-label'>身分證字號：</span>";
                echo "<span class='field-value'>" . htmlspecialchars($row['身分證字號']) . "</span>";
                echo "</div>";
                echo "<div class='card-field'>";
                echo "<span class='field-label'>電子郵件：</span>";
                echo "<span class='field-value'>" . htmlspecialchars($row['電子郵件']) . "</span>";
                echo "</div>";
                echo "<div class='card-field'>";
                echo "<span class='field-label'>電話：</span>";
                echo "<span class='field-value'>" . htmlspecialchars($row['電話']) . "</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "</div>";
                echo "</section>";
            } else {
                echo "<div class='error-message'>";
                echo "<h2>未找到符合的隊伍資料</h2>";
                echo "</div>";
            }
        } else {
            echo "<div class='error-message'>";
            echo "<h2>登入驗證失敗，請重新登入</h2>";
            echo "</div>";
        }

        // 關閉資料庫連線
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($team_stmt)) mysqli_stmt_close($team_stmt);
        if (isset($student_stmt)) mysqli_stmt_close($student_stmt);
        mysqli_close($link);
        ?>

        <div class="return-section">
            <form action="teacher_dashboard.php" method="POST">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
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
</body>
</html>
