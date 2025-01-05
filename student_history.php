<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="styles.css">
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
            <?php
            $works = [
                100 => [['隊伍A', '作品A說明書'], ['隊伍B', '作品B說明書']],
                101 => [['隊伍C', '作品C說明書'], ['隊伍D', '作品D說明書']],
                102 => [['隊伍E', '作品E說明書'], ['隊伍F', '作品F說明書']],
            ];
            $year = isset($_GET['year']) ? (int)$_GET['year'] : 100;
            ?>
            <h2>歷屆作品瀏覽</h2>
            <form method="GET" action="student_history.php">
                <label for="year">選擇年份：</label>
                    <select id="year" name="year">
                    <option value="100" <?= $year === 100 ? 'selected' : '' ?>>100 年</option>
                    <option value="101" <?= $year === 101 ? 'selected' : '' ?>>101 年</option>
                    <option value="102" <?= $year === 102 ? 'selected' : '' ?>>102 年</option>
                </select>
                <button type="submit">查詢</button>
                </form>
            <?php if (isset($works[$year])): ?>
                <table border="1">
                <tr>
                    <th>隊伍名稱</th>
                    <th>作品說明</th>
                </tr>
                <?php foreach ($works[$year] as $work): ?>
                    <tr>
                    <td><?= htmlspecialchars($work[0]) ?></td>
                    <td><?= htmlspecialchars($work[1]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>該年份無作品資料。</p>
            <?php endif; ?>
        </main> 
        <form action="main.php" method="POST">
        <button type="submit">回主頁</button>
    </form>
    </body>
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
</html>
