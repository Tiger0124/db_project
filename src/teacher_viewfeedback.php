<?php
  $username = $_POST["username"];
  $password = $_POST["password"];
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>查看評分與評語</title>
  <link rel="stylesheet" href="../asset/teacher_viewfeedback.css">
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
  <div class="container">
    <h2>評分與評語</h2>
    <div id="feedbackList">讀取中...</div>
    <button onclick="goBack()">返回主頁</button>
  </div>

  <script>
    const { createClient } = supabase;
    const supabaseClient = createClient(
      'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
      'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
    );

    const teamId = "<?php echo $username; ?>";

    async function loadFeedback() {
      const { data, error } = await supabaseClient
        .from('評分資料')
        .select('創意性, 完整性, 實用性, 評語')
        .eq('隊伍編號', teamId);

      const list = document.getElementById('feedbackList');
      if (error || !data) {
        list.innerHTML = `<p style="color:red;">讀取失敗：${error?.message || '未知錯誤'}</p>`;
        return;
      }

      if (data.length === 0) {
        list.innerHTML = '<p style="text-align:center; color:gray;">此隊伍尚無評分資料。</p>';
        return;
      }

      list.innerHTML = '';
      data.forEach((row) => {
        const box = document.createElement('div');
        box.className = 'feedback-box';
        box.innerHTML = `
          <p><strong>創意性：</strong> ${row.創意性 ?? '—'}</p>
          <p><strong>完整性：</strong> ${row.完整性 ?? '—'}</p>
          <p><strong>實用性：</strong> ${row.實用性 ?? '—'}</p>
          <p><strong>評語：</strong> ${row.評語?.trim() || '（無）'}</p>
        `;
        list.appendChild(box);
      });
    }

    function goBack() {
      const form = document.createElement('form');
      form.method = 'post';
      form.action = 'teacher_dashboard.php';

      form.innerHTML = `
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input type="hidden" name="password" value="<?php echo $password; ?>">
      `;
      document.body.appendChild(form);
      form.submit();
    }

    loadFeedback();
  </script>
</body>
</html>
