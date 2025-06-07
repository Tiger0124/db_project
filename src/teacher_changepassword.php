<?php include 'darkmode.php'; ?>
<?php
$username = $_POST["username"] ?? '';
$password = $_POST["password"] ?? '';
if ($username === '' || $password === '') {
  echo "<h2 style='color:red; text-align:center;'>請從教師主頁正確登入後進入此頁面。</h2>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <title>更改密碼</title>
  <link rel="stylesheet" href="../asset/teacher_changepassword.css">
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>

<body>
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

    const teamId = <?php echo json_encode($username); ?>;
    const oldPasswordPHP = <?php echo json_encode($password); ?>;

    document.getElementById("changePwForm").addEventListener("submit", async function(e) {
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

      const {
        error
      } = await supabase
        .from('指導老師')
        .update({
          密碼: newPassword
        })
        .eq('身分證字號', teamId)
        .eq('密碼', oldPassword);

      if (error) {
        alert("密碼更新失敗：" + error.message);
      } else {
        alert("密碼已更新，請重新登入。");
        window.location.href = "teacher.php";
      }
    });

    function goBack(newPw = oldPasswordPHP) {
      const form = document.createElement("form");
      form.method = "post";
      form.action = "teacher_dashboard.php";

      form.innerHTML = `
        <input type="hidden" name="username" value="${teamId}">
        <input type="hidden" name="password" value="${newPw}">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  </script>
</body>

</html>