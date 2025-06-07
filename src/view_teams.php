<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/view_students.css">
    <script 
    src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2.0.0/dist/umd/supabase.min.js">
    </script>
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
  <?php
    // 顯示刪除結果訊息
    if (isset($_POST['delete_success']) && $_POST['delete_success'] === '1') {
        echo '<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">隊伍刪除成功！</div>';
    }
    if (isset($_POST['delete_error'])) {
        echo '<div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">刪除失敗：' . htmlspecialchars($_POST['delete_error']) . '</div>';
    }
    ?>
    <form action="view_teams.php" method="POST">
        <select name="year">
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>
        <button type="submit">查詢</button>
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </form>

    <div class="rounded-box">
      <table style="width:100%">
          <tr>
              <th>隊伍名稱</th>
              <th>指導老師</th>
              <th>學生名單</th>
              <th>作品名稱</th>
              <th>作品說明書</th>
              <th>作品海報</th>
              <th>名次</th>
              <th>刪除</th>
          </tr>
      </table>
    </div>
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit">返回</button>
    </form>
  </main>

  <script>
    const { createClient } = supabase;
    const supabaseClient = createClient(
        'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
    );
    async function retrival(y) {
        const {data:teamData, error} = await supabaseClient
            .from('隊伍')
            .select(`*`)
            .eq('參加年份', y);

        if (error) {
            console.error("Error retrieving data:", error);
            return;
        }
        const {data:workData, error: workerror} = await supabaseClient
            .from('作品')
            .select(`*`)
            .eq('參加年份', y)
            .in('隊伍編號', teamData.map(team => team.隊伍編號));
        if (workerror) {
            console.error("Error retrieving work data:", workerror);
            return;
        }
        const {data: teacherData, error: teacherError} = await supabaseClient
            .from('指導老師')
            .select(`*`)
            .in('身分證字號', teamData.map(team => team.身分證字號));
        if (teacherError) {
            console.error("Error retrieving teacher data:", teacherError);
            return;
        }
        const { data: studentData, error: studentError } = await supabaseClient
            .from('學生')
            .select(`學號,隊伍編號,姓名`)
            .eq('參加年份',y)
            .in('隊伍編號', teamData.map(team => team.隊伍編號));
        const tabel = document.querySelector('table');
        tabel.innerHTML = `
            <tr>
                <th>隊伍名稱</th>
                <th>指導老師</th>
                <th>學生名單</th>
                <th>作品名稱</th>
                <th>作品說明書</th>
                <th>作品海報</th>
                <th>名次</th>
                <th>刪除</th>
            </tr>`;
        teamData.forEach(team => {
            const teamWork = workData.find(work => work.隊伍編號 === team.隊伍編號);
            const teacher = teacherData.find(t => t.身分證字號 === team.身分證字號);
            const students = studentData.filter(student => student.隊伍編號 === team.隊伍編號);
            const rank = team.名次 ? team.名次 : '未評分';

            tabel.innerHTML += `
                <tr>
                    <td>${team.隊伍名稱}</td>
                    <td>${teacher ? teacher.姓名 : '無'}</td>
                    <td>${students.length > 0 ? students.map(s => `${s.學號}: ${s.姓名}`).join('<br>') : '無'}</td>
                    <td>${teamWork ? teamWork.作品名稱 : '無'}</td>
                    <td>${teamWork ? `<a href="data:application/pdf;base64,${teamWork.說明書}" download="說明書.pdf">下載說明書</a>` : '無'}</td>
                    <td>${teamWork ? `<a href="data:application/pdf;base64,${teamWork.海報}" download="海報.pdf">下載海報</a>` : '無'}</td>
                    <td>${rank}</td>
                    <td><button type="button" class="delete_btn" data-id="${team.隊伍編號}">刪除</button></td>
                </tr>`;
        });
        const deleteButtons = document.querySelectorAll('.delete_btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', async (event) => {
                    const teamId = event.target.dataset.id;
                    const teamname = teamData.find(team => team.隊伍編號 === teamId).隊伍名稱;
                    if (!confirm(`確定要刪除「${teamname}」隊伍嗎？`)) return;
                    // 先刪作品
                    const { error: workDeleteError } = await supabaseClient
                        .from('作品')
                        .delete()
                        .eq('隊伍編號', teamId)
                        .eq('參加年份', y);
                    if (workDeleteError) {
                        console.error("Error deleting work data:", workDeleteError);
                        return;
                    }
                    // 再刪學生
                    const { error: studentDeleteError } = await supabaseClient
                        .from('學生')
                        .update({隊伍編號: null,參加年份: null})
                        .eq('隊伍編號', teamId)
                        .eq('參加年份', y);
                    if (studentDeleteError) {
                        console.error("Error deleting student data:", studentDeleteError);
                        return;
                    }
                    // 老師
                    const { error: teacherDeleteError } = await supabaseClient
                        .from('指導老師')
                        .update({隊伍編號: null,參加年份: null})
                        .eq('隊伍編號', teamId)
                        .eq('參加年份', y);
                    if (teacherDeleteError) {
                        console.error("Error deleting teacher data:", teacherDeleteError);
                        return;
                    }
                    // 刪除評分資料
                    const { error: scoreDeleteError } = await supabaseClient
                        .from('評分資料')
                        .delete()
                        .eq('隊伍編號', teamId)
                        .eq('參加年份', y);
                    if (scoreDeleteError) {
                        console.error("Error deleting score data:", scoreDeleteError);
                        return;
                    }
                    // 最後刪隊伍
                    const { error: teamDeleteError } = await supabaseClient
                        .from('隊伍')
                        .delete()
                        .eq('隊伍編號', teamId)
                        .eq('參加年份', y);
                    if (teamDeleteError) {
                        console.error("Error deleting team data:", teamDeleteError);
                        return;
                    }
                    // 刪除成功，重新載入資料
                    alert(`隊伍「${teamname}」刪除成功！`);
                    retrival(y);
                });
            });
        if (teamData.length === 0) {
            tabel.innerHTML += `<tr><td colspan="8">沒有找到符合條件的隊伍資料</td></tr>`;
        }
    }
    const yearSelect = document.querySelector('select[name="year"]');

    document.querySelector('form[action="view_teams.php"]').addEventListener('submit', function (event) {
        event.preventDefault();
        const selectedYear = yearSelect.value;
        retrival(selectedYear);
    });

    
  </script>
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
