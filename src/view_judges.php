<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/view_judges.css">
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
    <form action="view_judges.php" method="POST">
        <select name="year">
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        </select>
        <button type="submit">查詢</button>
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
    </form>
    <table>
        <!-- <tr>
            <th>身分證字號</th>
            <th>電子郵件</th>
            <th>頭銜</th>
            <th>姓名</th>
            <th>電話</th>
        </tr> -->
        <?php
        require_once 'conn.php'; // 引入連線設定
        $yearToSession = [2013 => "第1屆", 2014 => "第2屆", 2015 => "第3屆", 2016 => "第4屆",
            2017 => "第5屆", 2018 => "第6屆", 2019 => "第7屆", 2020 => "第8屆",
            2021 => "第9屆", 2022 => "第10屆", 2023 => "第11屆", 2024 => "第12屆",
            2025 => "第13屆"];
        // 移除原本的 MySQL 連線程式碼
        // $link = mysqli_connect(...);
        // mysqli_select_db(...);

        // 使用 $supabaseClient 進行資料庫查詢
        try {
            if (isset($_POST['year']) && array_key_exists($_POST['year'], $yearToSession)) {
                $session = $yearToSession[$_POST['year']];
                $selectedYear = $_POST['year']; // $sessionTextForDisplay = $yearToSession[$selectedYear]; // 如果需要在標題等地方顯示 "第X屆"

                $response = $supabaseClient->get('評審委員', [
                    'query' => [
                        '參加年份' => 'eq.' . $selectedYear, // <--- 修正點：使用 '參加年份' 欄位
                        'select' => '*', // 選擇所有欄位
                    ]
                ]);
                //$judgesData = json_decode($response->getBody()->getContents(), true);
                $data = json_decode($response->getBody(), true);

                echo "<table border='1'>";
                echo "<tr><th>身分證字號</th><th>電子郵件</th><th>頭銜</th><th>姓名</th><th>電話</th></tr>";

                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['身分證字號']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['電子郵件']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['頭銜']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['姓名']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['電話']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        } catch (Exception $e) {
            echo "查詢評審資料錯誤: " . $e->getMessage();
        }
        ?>

    </table>
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
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