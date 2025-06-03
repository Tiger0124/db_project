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

$filename = $_POST["username"];
$filepasswd = $_POST["password"];

try {
    // 查詢指導老師是否存在
    $response = $supabaseClient->get('指導老師', [
        'query' => [
            '隊伍編號' => 'eq.' . $filename,
            '身分證字號' => 'eq.' . $filepasswd
        ]
    ]);
    $data = json_decode($response->getBody(), true);

    if (count($data) === 1) {
        $row = $data[0];  // 指導老師資料
        $team_id = $row['隊伍編號'];

        // 查詢隊伍與作品資料
        $response_team = $supabaseClient->get('作品', [
            'query' => ['隊伍編號' => 'eq.' . $team_id]
        ]);
        $作品 = json_decode($response_team->getBody(), true);

        $response_team2 = $supabaseClient->get('隊伍', [
            'query' => ['隊伍編號' => 'eq.' . $team_id]
        ]);
        $隊伍 = json_decode($response_team2->getBody(), true);

        if (count($作品) > 0 && count($隊伍) > 0) {
            $team_row = array_merge($作品[0], $隊伍[0]); // 合併資料
            $blob = base64_encode($team_row['說明書']);

            echo "<section class='team-info'>";
            echo "<h2>指導的隊伍資訊</h2>";
            echo "<div class='team-details'>";
            echo "<div class='team-basic-info'>";
            echo "<h3>隊伍基本資料</h3>";
            echo "<div class='info-item'><span class='label'>隊伍名稱：</span><span class='value'>" . htmlspecialchars($team_row['隊伍名稱']) . "</span></div>";
            echo "<div class='info-item'><span class='label'>作品說明書：</span><a href='data:application/pdf;base64," . $blob . "' download class='download-link'>下載說明書</a></div>";
            echo "<div class='info-item'><span class='label'>作品影片網址：</span><a href='" . htmlspecialchars($team_row['作品展示_youtube連結']) . "' target='_blank' class='external-link'>" . htmlspecialchars($team_row['作品展示_youtube連結']) . "</a></div>";
            echo "<div class='info-item'><span class='label'>作品程式碼網址：</span><a href='" . htmlspecialchars($team_row['程式碼_Github連結']) . "' target='_blank' class='external-link'>" . htmlspecialchars($team_row['程式碼_Github連結']) . "</a></div>";
            echo "</div>";

            // 查詢學生資料
            $response_students = $supabaseClient->get('學生', [
                'query' => [
                    '隊伍編號' => 'eq.' . $team_id
                ]
            ]);
            $students_data = json_decode($response_students->getBody(), true);

            // 顯示學生資料（表格 + 卡片）
            include 'components/student_table.php';  // 表格與卡片統一顯示（可選擇外部化）

            // 顯示指導教授資料
            include 'components/professor_table.php'; // 外部檔案呈現樣式（可選）

            echo "</div></section>";
        } else {
            echo "<div class='error-message'><h2>未找到符合的隊伍資料</h2></div>";
        }
    } else {
        echo "<div class='error-message'><h2>登入驗證失敗，請重新登入</h2></div>";
    }
} catch (Exception $e) {
    echo "<div class='error-message'><h2>系統錯誤：" . htmlspecialchars($e->getMessage()) . "</h2></div>";
}
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
