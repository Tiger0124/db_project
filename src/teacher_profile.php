<?php
  session_start();
  $username = $_POST["username"];
  $password = $_POST["password"]; // 假設密碼為老師的身分證字號
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>編輯個人資料</title>
  <link rel="stylesheet" href="../asset/teacher_profile.css">
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
  <div class="container">
    <h2>編輯個人資料</h2>

    <form id="profileForm">
      <label>身分證字號（不可修改）
        <input type="text" id="id" disabled>
      </label>
      <label>姓名
        <input type="text" id="name">
      </label>
      <label>電話
        <input type="text" id="phone">
      </label>
      <label>電子郵件
        <input type="email" id="email">
      </label>
      <label>職稱
        <input type="text" id="title">
      </label>
      <button type="submit">儲存變更</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
      <button onclick="goBack()" style="padding: 10px 20px; background-color: #aaa; border: none; border-radius: 5px; color: white; cursor: pointer;">
        返回
      </button>
    </div>

<script>
  const { createClient } = supabase;
  const supabaseClient = createClient(
    'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
    'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
  );

  // ✅ 把 PHP 中的帳號與身分證帶進 JS
  const userId = "<?php echo $password; ?>";
  const username = "<?php echo $username; ?>";
  console.log('userId:', userId);

  async function loadProfile() {
    const { data, error } = await supabaseClient
      .from('指導老師')
      .select('*')
      .eq('身分證字號', username)
      .single();
    console.log('讀取資料', data);

    if (error) {
      alert('讀取資料失敗：' + error.message);
      console.error('讀取錯誤', error);
      return;
    }

    document.getElementById('id').value = data.身分證字號;
    document.getElementById('name').value = data.姓名;
    document.getElementById('phone').value = data.電話;
    document.getElementById('email').value = data.電子郵件;
    document.getElementById('title').value = data.職稱;
  }

  document.getElementById('profileForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const updates = {
      姓名: document.getElementById('name').value,
      電話: document.getElementById('phone').value,
      電子郵件: document.getElementById('email').value,
      職稱: document.getElementById('title').value,
    };

    const { error } = await supabaseClient
      .from('指導老師')
      .update(updates)
      .eq('身分證字號', username);

    if (error) {
      alert('更新失敗：' + error.message);
      console.error('更新錯誤', error);
    } else {
      alert('資料更新成功，將返回主頁...');

      // ✅ 自動建立並送出一個 POST 表單，回到 teacher_dashboard
      const form = document.createElement('form');
      form.method = 'post';
      form.action = 'teacher_dashboard.php';

      const input1 = document.createElement('input');
      input1.type = 'hidden';
      input1.name = 'username';
      input1.value = username;

      const input2 = document.createElement('input');
      input2.type = 'hidden';
      input2.name = 'password';
      input2.value = userId;

      form.appendChild(input1);
      form.appendChild(input2);
      document.body.appendChild(form);
      form.submit();
    }
  });

  loadProfile();

  function goBack() {
  // 直接跳轉回 dashboard 並保留登入資訊
  const form = document.createElement('form');
  form.method = 'post';
  form.action = 'teacher_dashboard.php';

  const input1 = document.createElement('input');
  input1.type = 'hidden';
  input1.name = 'username';
  input1.value = username;

  const input2 = document.createElement('input');
  input2.type = 'hidden';
  input2.name = 'password';
  input2.value = userId;

  form.appendChild(input1);
  form.appendChild(input2);
  document.body.appendChild(form);
  form.submit();
}

</script>

</body>
</html>
