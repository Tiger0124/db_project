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
    
    <div class="rounded-box">
        <table style="width:100%">
            <tr>
                <th>身分證字號</th>
                <th>電子郵件</th>
                <th>頭銜</th>
                <th>姓名</th>
                <th>電話</th>
            </tr>
            <?php
            session_start();
            require_once 'conn.php';

            $selectedYear = 2013; // 預設年份
            // 年份到屆數的對應陣列
            $yearToSession = [
                2013 => "1", 2014 => "2", 2015 => "3", 2016 => "4",
                2017 => "5", 2018 => "6", 2019 => "7", 2020 => "8",
                2021 => "9", 2022 => "10", 2023 => "11", 2024 => "12",
                2025 => "13"
            ];

            // 檢查是否有提交表單並且選擇的年份是有效的
            if (isset($_POST['year']) && array_key_exists($_POST['year'], $yearToSession)) {
                $selectedYear = $_POST['year'];
                $session = $yearToSession[$selectedYear];
                try {
                    // 使用 $supabaseClient 進行查詢
                    $response = $supabaseClient->get('評審委員', [
                        'query' => [
                            '屆數' => 'eq.' . $session,
                            'select' => '*',
                        ]
                    ]);

                    $status_code = $response->getStatusCode();
                    
                    if ($status_code == 200) {
                        $judgesData = json_decode($response->getBody()->getContents(), true);

                        if (!empty($judgesData)) {
                            foreach ($judgesData as $row) {
                                echo "<tr>";
                                
                                // 身分證字號
                                $id_number = isset($row['身分證字號']) ? htmlspecialchars($row['身分證字號'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $id_number . "</td>";
                                
                                // 電子郵件
                                $email = isset($row['電子郵件']) ? htmlspecialchars($row['電子郵件'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $email . "</td>";
                                
                                // 頭銜
                                $title = isset($row['頭銜']) ? htmlspecialchars($row['頭銜'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $title . "</td>";
                                
                                // 姓名
                                $name = isset($row['姓名']) ? htmlspecialchars($row['姓名'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $name . "</td>";
                                
                                // 電話
                                $phone = isset($row['電話']) ? htmlspecialchars($row['電話'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $phone . "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>查無 " . htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8') . " 年度的評審委員資料。</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>查詢評審委員資料失敗，HTTP 狀態碼：" . $status_code . "</td></tr>";
                    }
                } catch (GuzzleHttp\Exception\RequestException $e) {
                    echo "<tr><td colspan='5'>Guzzle 請求錯誤: ";
                    if ($e->hasResponse()) {
                        echo htmlspecialchars($e->getResponse()->getBody()->getContents(), ENT_QUOTES, 'UTF-8');
                    } else {
                        echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                    }
                    echo "</td></tr>";
                } catch (Exception $e) {
                    echo "<tr><td colspan='5'>執行查詢時發生例外狀況: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
                }
            }
            ?>
        </table>
    </div>
    
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