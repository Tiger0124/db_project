<?php
include 'conn.php';

// 預設年份為 2024，或根據使用者選擇的年份
$year = isset($_GET['year']) ? (int)$_GET['year'] : 2024;

// 安全性檢查（允許的年份範圍）
$allowedYears = range(2013, 2024); // 從 2013 到 2024
if (!in_array($year, $allowedYears, true)) {
    $year = 2024; // 預設年份
}

$sql = "
    SELECT 
        隊伍.屆數, 隊伍.隊伍編號, 隊伍.隊伍名稱, 
        作品.作品名稱, 作品.說明書, 作品.海報, 
        作品.作品展示_youtube連結, 作品.程式碼_Github連結 
    FROM 隊伍 
    NATURAL JOIN 作品 
    WHERE 隊伍.參加年份 = '$year'
";

$result = mysqli_query($link, $sql);
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
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
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
                <?php endwhile; ?>
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
