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
    <form action="view_scores.php" method="POST">
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
        <tr>
            <th>隊伍</th>
            <th>評審:得分</th>
            <th>名次</th>
        </tr>
        <?php
            include 'conn.php';
            $yearToSession = [
              2013 => "第1屆",
              2014 => "第2屆",
              2015 => "第3屆",
              2016 => "第4屆",
              2017 => "第5屆",
              2018 => "第6屆",
              2019 => "第7屆",
              2020 => "第8屆",
              2021 => "第9屆",
              2022 => "第10屆",
              2023 => "第11屆",
              2024 => "第12屆",
              2025 => "第13屆"
          ];
            $select_db = @mysqli_select_db($link, "db_project"); //選擇資料庫
            if (isset($_POST['year'])&& array_key_exists($_POST['year'], $yearToSession)) { // 確認是否有提交表單
              $session = $yearToSession[$_POST['year']];
              $sql = "SELECT 隊伍.隊伍名稱, 隊伍.名次, GROUP_CONCAT(CONCAT(評審委員.姓名, ': ', 評分資料.評分) SEPARATOR '; ') AS 評審分數
              FROM 
                  隊伍
              JOIN 
                  評分資料 ON 隊伍.隊伍編號 = 評分資料.隊伍編號
              JOIN 
                  評審委員 ON 評分資料.身分證字號 = 評審委員.身分證字號 and 評分資料.屆數 = 評審委員.屆數
              WHERE 
                  隊伍.參加年份 = '".$_POST['year']."'
              GROUP BY 
                  隊伍.隊伍編號;
              "; 
              // Step 1: 計算總分並創建臨時表格
              $sql1 = "CREATE TEMPORARY TABLE 排名 AS
              SELECT 
                  評分資料.隊伍編號, 
                  ROW_NUMBER() OVER (ORDER BY SUM(評分資料.評分) DESC) AS 名次
              FROM 
                  評分資料
              GROUP BY 
                  評分資料.隊伍編號";
              mysqli_query($link, $sql1);

              // Step 2: 更新隊伍名次
              $sql2 = "UPDATE 隊伍 
              JOIN 排名 ON 隊伍.隊伍編號 = 排名.隊伍編號
              SET 隊伍.名次 = 排名.名次";
              mysqli_query($link, $sql2);

              $result = mysqli_query($link, $sql);
              while($row = mysqli_fetch_assoc($result)){
                  echo "<tr>";
                  echo "<td>".$row['隊伍名稱']."</td>";
                  echo "<td>".$row['評審分數']."</td>";
                  echo "<td>".$row['名次']."</td>";
                  echo "</tr>";
              }
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
