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
    <section class="announcement-section">
      <h2>發布公告</h2>
      <form action="post_announcement.php" method="POST" enctype="multipart/form-data">
        <!-- 公告標題 -->
        <?php
        include 'conn.php';
        $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        echo "<label for='announcement-content'>公告內容：</label>";
        echo "<textarea id='announcement-content' name='announcement_content' rows='5' required>" . htmlspecialchars($row['公告內容']) . "</textarea>";

        echo "<label for='competition-rules'>比賽規則：</label>";
        echo "<textarea id='competition-rules' name='competition_rules' rows='5' required>" . htmlspecialchars($row['比賽規則']) . "</textarea>";

        echo "<label for='announcement-file'>上傳檔案：</label>";
        echo "<input type='file' id='announcement-file' name='announcement_file' accept='.pdf' required>";
        ?>
        
        <!-- 提交按鈕 -->
        <button type="submit">發布公告</button>
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
      </form>
    </section>
  
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
