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
    <form action="view_students.php" method="POST">
        <select name="year">
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        </select>
        <button type="submit">查詢</button>
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
          <tr>
              <td>c哈哈哈</td>
              <td>吳俊興</td>
              <td>李憲昌 林柏諺 宋暐峻 何皓宇 </td>
              <td>作品名稱</td>
              <td>作品描述</td>
          </tr>
      </table>
    </div>
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
</body>
</html>
