<?php
  $username = $_POST["username"] ?? '';
  $password = $_POST["password"] ?? '';
  if ($username === '' || $password === '') {
    echo "<h2 style='color:red; text-align:center;'>請從評審主頁正確登入後進入此頁面。</h2>";
    echo '<button onclick="window.location.href=\'main.php\'" style="display:block; margin: 0 auto; padding: 10px 20px; font-size: 16px;">返回主頁</button>';
    exit;
  }
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/judge_changepassword.css">
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
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
  <div class="container">
    <h2>更改密碼</h2>
    <form id="changePwForm">
      <label>舊密碼
        <input type="password" id="oldPassword" required>
      </label>
      <label>新密碼
        <input type="password" id="newPassword" required>
      </label>
      <label>確認新密碼
        <input type="password" id="confirmPassword" required>
      </label>
      <button type="submit">更新密碼</button>
    </form>
    <button onclick="goBack()">返回主頁</button>
  </div>

  <script>
    const supabase = window.supabase.createClient(
      'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
      'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
    );

    const username = <?php echo json_encode($username); ?>;
    const password = <?php echo json_encode($password); ?>;
    const oldPasswordPHP = password;

    document.getElementById("changePwForm").addEventListener("submit", async function (e) {
      e.preventDefault();

      const oldPassword = document.getElementById("oldPassword").value;
      const newPassword = document.getElementById("newPassword").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      if (oldPassword !== oldPasswordPHP) {
        alert("舊密碼錯誤！");
        return;
      }

      if (newPassword === oldPassword) {
        alert("新密碼不可與舊密碼相同！");
        return;
      }

      if (newPassword !== confirmPassword) {
        alert("新密碼與確認密碼不符！");
        return;
      }

      const { error } = await supabase
        .from('評審委員')
        .update({ 密碼: newPassword })
        .eq('身分證字號', username)
        .eq('密碼', oldPassword);

      if (error) {
        alert("密碼更新失敗：" + error.message);
      } else {
        alert("密碼已更新，請重新登入。");
        window.location.href="judge.php";
      }
    });

    function goBack(newPw = oldPasswordPHP) {
      const form = document.createElement("form");
      form.method = "post";
      form.action = "judge_dashboard.php";

      form.innerHTML = `
        <input type="hidden" name="username" value="${username}">
        <input type="hidden" name="password" value="${newPw}">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  </script>
  <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; Copyright © 2025 XC Lee Tiger Lin How Ho. All rights reserved.</p>
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
</body>
</html>
