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
      <img src="images/logo.png" alt="Logo" class="logo">
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
        </select>
        <button type="submit">查詢</button>
    </form>
    <table>
        <tr>
            <th>隊伍</th>
            <th>得分</th>
            <th>名次</th>
        </tr>
        <tr>
            <td>隊伍</td>
            <td>得分</td>
            <td>名次</td>
        </tr>
    </table>
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
</body>
</html>
