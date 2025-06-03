<?php
include 'conn.php';

// 預設年份為 2024，或根據使用者選擇的年份
$year = isset($_GET['year']) ? (int)$_GET['year'] : 2024;

// 安全性檢查（允許的年份範圍）
$allowedYears = range(2013, 2024);
if (!in_array($year, $allowedYears, true)) {
    $year = 2024;
}

// 查詢該年份的所有隊伍資料
$response_team = $supabaseClient->get('隊伍', [
    'query' => ['參加年份' => 'eq.' . $year]
]);
$teams = json_decode($response_team->getBody(), true);

// 查詢所有作品資料（等下做比對）
$response_work = $supabaseClient->get('作品');
$works = json_decode($response_work->getBody(), true);

// 合併：以隊伍編號為 key 對應作品
$merged = [];
foreach ($teams as $team) {
    $team_id = $team['隊伍編號'];
    foreach ($works as $work) {
        if ($work['隊伍編號'] === $team_id) {
            $merged[] = array_merge($team, $work);
            break;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="student_history.css">
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
<main id="content">
    <h2>歷屆作品瀏覽</h2>
    <form method="GET" action="">
        <label for="year">選擇年份：</label>
        <select id="year" name="year">
            <?php foreach ($allowedYears as $y): ?>
                <option value="<?= $y ?>" <?= $year === $y ? 'selected' : '' ?>><?= $y ?> 年</option>
            <?php endforeach; ?>
        </select>
        <button type="submit">查詢</button>
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>隊伍名稱</th>
                <th>作品名稱</th>
                <th>說明書</th>
                <th>海報</th>
                <th>影片連結</th>
                <th>程式碼連結</th>
            </tr>
        </thead>
        <tbody>

<?php if (!empty($merged)): ?>
    <?php foreach ($merged as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['隊伍名稱']) ?></td>
            <td><?= htmlspecialchars($row['作品名稱']) ?></td>
            <td>
                <a href="data:application/pdf;base64,<?= base64_encode($row['說明書']) ?>" download>下載說明書</a>
            </td>
            <td>
                <a href="data:application/pdf;base64,<?= base64_encode($row['海報']) ?>" download>下載海報</a>
            </td>
            <td>
                <a href="<?= htmlspecialchars($row['作品展示_youtube連結']) ?>" target="_blank">影片連結</a>
            </td>
            <td>
                <a href="<?= htmlspecialchars($row['程式碼_Github連結']) ?>" target="_blank">程式碼連結</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6">該年份無資料。</td>
    </tr>
<?php endif; ?>

        </tbody>
    </table>
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
