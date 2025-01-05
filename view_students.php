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
    <form action="view_students.php" method="POST">
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
        <table style="width:100% ">
            <tr>
                <th>隊伍名稱</th>
                <th>指導老師</th>
                <th>學生名單</th>
                <th>作品名稱</th>
                <th>作品描述</th>
            </tr>
            <!-- <tr>
                <td>c哈哈哈</td>
                <td>吳俊興</td>
                <td>李憲昌 林柏諺 宋暐峻 何皓宇 </td>
                <td>作品名稱</td>
                <td>作品描述</td>
            </tr> -->
            <?php
                include 'conn.php';
                $select_db = @mysqli_select_db($link, "db_project"); //選擇資料庫
                if (isset($_POST['year'])) { // 確認是否有提交表單
                  $sql = "SELECT 指導老師.姓名 as 指導老師姓名, GROUP_CONCAT(學生.姓名 SEPARATOR ', ') AS 學生名單, 隊伍名稱 FROM 隊伍 join 指導老師 ON 隊伍.隊伍編號 = 指導老師.隊伍編號 join 學生 ON 隊伍.隊伍編號 = 學生.隊伍編號 WHERE 隊伍.參加年份 = '".$_POST['year']."'";
                  $result = mysqli_query($link, $sql);
                  while($row = mysqli_fetch_assoc($result)){
                      echo "<tr>";
                      echo "<td>".$row['隊伍名稱']."</td>";
                      echo "<td>".$row['指導老師姓名']."</td>";
                      echo "<td>".$row['學生名單']."</td>";
                      echo "<td>".$row['隊伍名稱']."</td>";
                      echo "<td>".$row['隊伍名稱']."</td>";
                      echo "</tr>";
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
  </main>
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
