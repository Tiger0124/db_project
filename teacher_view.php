<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師指導隊伍資料</title>
    <link rel="stylesheet" href="styles.css">
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

    <?php
    include 'conn.php';
    $select_db = @mysqli_select_db($link, "db_project"); // 選擇資料庫
    // 從表單中獲取用戶傳送過來的資料
    $filename = $_POST["username"];
    $filepasswd = $_POST["password"];

    // 使用 Prepared Statement 查詢指導老師資料
    $sql = "SELECT * FROM 指導老師 WHERE 隊伍編號 = ? AND 身分證字號 = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $filename, $filepasswd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 取得隊伍編號
    $row = mysqli_fetch_assoc($result);
    $team_id = $row['隊伍編號'];

    // 取得隊伍和學生資料
    $team_sql = "
    SELECT 隊伍.隊伍編號, 說明書, 作品展示_youtube連結, 程式碼_Github連結, 隊伍名稱
    FROM 作品 join 隊伍 on 作品.隊伍編號 = 隊伍.隊伍編號
    WHERE 隊伍.隊伍編號 = ?";

    if ($team_stmt = mysqli_prepare($link, $team_sql)) {
        // 綁定參數
        mysqli_stmt_bind_param($team_stmt, "s", $team_id);

        // 執行查詢
        mysqli_stmt_execute($team_stmt);

        // 取得結果
        $team_result = mysqli_stmt_get_result($team_stmt);
        
        if (mysqli_num_rows($team_result) > 0) {
            // 顯示隊伍資訊
            echo "<main><section class='team-info'><h2>指導的隊伍資訊</h2>";
            
            // 顯示隊伍資料
            $team_row = mysqli_fetch_assoc($team_result);
            $blob = base64_encode($team_row['說明書']);
            echo "
            <div class='team'>
                <p><strong>隊伍名稱：" . $team_row['隊伍名稱'] . "</strong></p>
                <p><strong>作品說明書：</strong>
                    <a href='data:application/pdf;base64," . $blob . "' download>下載說明書</a>
                </p>
                <p><strong>作品影片網址：</strong> 
                    <a href='" . $team_row['作品展示_youtube連結'] . "' target='_blank'>" . $team_row['作品展示_youtube連結'] . "</a>
                </p>
                <p><strong>作品程式碼網址：</strong> 
                    <a href='" . $team_row['程式碼_Github連結'] . "' target='_blank'>" . $team_row['程式碼_Github連結'] . "</a>
                </p>";

            // 取得學生資料
            $student_sql = "
            SELECT 身分證字號, 學號, 姓名, 電子郵件, 電話, 科系, 年級
            FROM 學生
            WHERE 隊伍編號 = ?";
            
            if ($student_stmt = mysqli_prepare($link, $student_sql)) {
                // 綁定參數
                mysqli_stmt_bind_param($student_stmt, "s", $team_id);

                // 執行查詢
                mysqli_stmt_execute($student_stmt);

                // 取得學生結果
                $student_result = mysqli_stmt_get_result($student_stmt);

                // 顯示學生資料
                echo "<h4>學生資料</h4>
                <table>
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>學號</th>
                            <th>身分證字號</th>
                            <th>科系</th>
                            <th>年級</th>
                            <th>電子郵件</th>
                            <th>電話</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                while ($student_row = mysqli_fetch_assoc($student_result)) {
                    echo "<tr>
                        <td>" . $student_row['姓名'] . "</td>
                        <td>" . $student_row['學號'] . "</td>
                        <td>" . $student_row['身分證字號'] . "</td>
                        <td>" . $student_row['科系'] . "</td>
                        <td>" . $student_row['年級'] . "</td>
                        <td>" . $student_row['電子郵件'] . "</td>
                        <td>" . $student_row['電話'] . "</td>
                    </tr>";
                }

                echo "</tbody></table>";

                // 顯示指導教授資料
                echo "<h4>指導教授</h4>
                <table>
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>身分證字號</th>
                            <th>電子郵件</th>
                            <th>電話</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>" . $row['姓名'] . "</td>
                            <td>" . $row['身分證字號'] . "</td>
                            <td>" . $row['電子郵件'] . "</td>
                            <td>" . $row['電話'] . "</td>
                        </tr>
                    </tbody>
                </table>";
            }

            echo "</div></section></main>";
        } else {
            echo "<p>未找到符合的隊伍資料。</p>";
        }
    } else {
        echo "查詢錯誤: " . mysqli_error($link);
    }

    // 關閉資料庫連線
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($team_stmt);
    mysqli_close($link);
    ?>

    <form action="teacher_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
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
