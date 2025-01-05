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
    <form action="view_judges.php" method="POST">
        <select name="year">
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
            <th>身分證字號</th>
            <th>電子郵件</th>
            <th>頭銜</th>
            <th>姓名</th>
            <th>電話</th>
        </tr>
        <?php
            include 'conn.php';
            $yearToSession = [
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
              $sql = "SELECT * FROM 評審委員 WHERE 評審委員.屆數 = '".$session."'";
              $result = mysqli_query($link, $sql);
              while($row = mysqli_fetch_assoc($result)){
                  echo "<tr>";
                  echo "<td>".$row['身分證字號']."</td>";
                  echo "<td>".$row['電子郵件']."</td>";
                  echo "<td>".$row['頭銜']."</td>";
                  echo "<td>".$row['姓名']."</td>";
                  echo "<td>".$row['電話']."</td>";
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
</html>
