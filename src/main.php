<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/main.css">
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
    <main id="content">
        <h2>歡迎進入創意競賽管理系統</h2>
        <div class="rounded-box">
            <div class="button-container">
                <a href="admin.php" class="system-button">管理員系統</a>
                <a href="student.php" class="system-button">學生系統</a>
                <a href="teacher.php" class="system-button">指導老師系統</a>
                <a href="judge.php" class="system-button">評審系統</a>
            </div>
        </div>
        
        <table>
                <thead>
                    <tr>
                        <th>公告內容</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            include 'conn.php';
                            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<td>" . $row['公告內容'] . "</td>";
                            }
                        ?>
                    </tr>
        </table>
        <table>
                <thead>
                    <tr>
                        <th>比賽規則</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            include 'conn.php';
                            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<td>" . $row['比賽規則'] . "</td>";
                            }
                        ?>
                    </tr>
        </table>
        <?php
            include 'conn.php';
            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $blob = base64_encode($row['宣傳海報']);
                echo "<a href='data:application/pdf;base64," . $blob . "' download>宣傳海報.pdf</a>";
            }
        ?>
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