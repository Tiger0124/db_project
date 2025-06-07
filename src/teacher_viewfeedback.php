<?php include 'darkmode.php'; ?>
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
    const {
      createClient
    } = supabase;
    const supabaseClient = createClient(
      'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
      'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
    );

    const teamId = "<?php echo $username; ?>";

    async function loadFeedback() {
      const {
        data,
        error
      } = await supabaseClient
        .from('指導老師')
        .select('身分證字號, 隊伍編號, 參加年份')
        .eq('身分證字號', teamId);

      const teamData = data[0];
      if (!teamData.隊伍編號) {
        document.getElementById('feedbackList').innerHTML = '<p style="color:red;">找不到該指導老師的隊伍資料。</p>';
        return;
      }

      const {
        data: feedbackData,
        error: feedbackError
      } = await supabaseClient
        .from('評分資料')
        .select('*')
        .eq('隊伍編號', teamData.隊伍編號)
        .eq('參加年份', teamData.參加年份);

      if (feedbackError || feedbackData.length === 0) {
        document.getElementById('feedbackList').innerHTML = '<p>尚無評分資料。</p>';
        return;
      }

      // 🔍 取得所有評審身分證字號
      const reviewerIds = [...new Set(feedbackData.map(item => item.身分證字號))];

      // 🔍 查出所有評審姓名
      const {
        data: reviewers,
        error: reviewerError
      } = await supabaseClient
        .from('評審委員')
        .select('身分證字號, 姓名')
        .in('身分證字號', reviewerIds);

      // 建立身分證 => 姓名的對照表
      const reviewerMap = {};
      reviewers.forEach(r => {
        reviewerMap[r.身分證字號] = r.姓名;
      });

      // ✅ 顯示資料
      const listHTML = feedbackData.map((item, index) => `
      <div class="feedback-item">
        <h4>評審：${reviewerMap[item.身分證字號] || '未知評審'}</h4>
        <p><strong>創意性：</strong> ${item.創意性}</p>
        <p><strong>完整性：</strong> ${item.完整性}</p>
        <p><strong>實用性：</strong> ${item.實用性}</p>
        <p><strong>評語：</strong> ${item.評語}</p>
        <hr>
      </div>
    `).join('');

      document.getElementById('feedbackList').innerHTML = listHTML;
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