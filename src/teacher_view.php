<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師指導隊伍資料</title>
    <link rel="stylesheet" href="../asset/teacher_view.css">
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" class="logo">
                <img src="../images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main>
    <div class="container">
  <section id="teamContent"></section>
    </div>

    <script>
    const { createClient } = supabase;
    const supabaseClient = createClient
        ('https://xlomzrhmzjjfjmsvqxdo.supabase.co',
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo');

    const name = "<?php echo $_POST['username']; ?>";

    async function loadTeamdata() {
    const { data: teacherData } = await supabaseClient
        .from('指導老師')
        .select('*')
        .eq('身分證字號', name);

    if (!teacherData || teacherData.length === 0) {
        document.getElementById('teamContent').innerHTML = '<p>查無指導老師資料</p>';
        return;
    }

    const { 參加年份, 隊伍編號 } = teacherData[0];

    const [{ data: teamData }, { data: workData }, { data: studentData }] = await Promise.all([
        supabaseClient.from('隊伍').select('*').eq('隊伍編號', 隊伍編號).eq('參加年份', 參加年份),
        supabaseClient.from('作品').select('*').eq('隊伍編號', 隊伍編號).eq('參加年份', 參加年份),
        supabaseClient.from('學生').select('*').eq('隊伍編號', 隊伍編號).eq('參加年份', 參加年份)
    ]);

    const team = teamData[0];
    const work = workData[0];

    let html = `<section class='team-info'>`;

    if(!team) {
        html += '<p>您目前並未指導任何團隊</p>';
        document.getElementById('teamContent').innerHTML = html;
        return;
    }

    // 🧑‍🎓 學生資料
    html += `<h2>隊員資料</h2><div class="team-details">`;
    studentData.forEach(s => {
        html += `
        <div class="info-item"><span class="label">姓名：</span><span class="value">${s.姓名}</span></div>
        <div class="info-item"><span class="label">學號：</span><span class="value">${s.學號}</span></div>
        <div class="info-item"><span class="label">科系：</span><span class="value">${s.科系}</span></div>
        <div class="info-item"><span class="label">電子郵件：</span><span class="value">${s.電子郵件}</span></div>
        <hr/>
        `;
    });
    html += `</div>`;

    // 🧾 隊伍基本資料
    html += `<h2>隊伍資訊</h2><div class="team-details team-basic-info">`;
    html += `<div class="info-item"><span class="label">隊伍名稱：</span><span class="value">${team.隊伍名稱}</span></div>`;
    html += `<div class="info-item"><span class="label">報名進度：</span><span class="value">${team.報名進度 || '無'}</span></div>`;
    html += `<div class="info-item"><span class="label">名次：</span><span class="value">${team.名次 || '尚未公布'}</span></div>`;
    html += `</div>`;

    // 📄 作品資訊
    html += `<h2>作品資訊</h2><div class="team-details">`;
    if (work.說明書) {
        const pdfBase64 = work.說明書; // 如果是 base64，這邊就可直接使用
        html += `<div class="info-item"><span class="label">作品說明書：</span><a href="data:application/pdf;base64,${pdfBase64}" download class="download-link">下載說明書</a></div>`;
    }
    html += `
        <div class="info-item"><span class="label">作品名稱：</span><span class="value">${work.作品名稱 || '未命名'}</span></div>
        <div class="info-item"><span class="label">作品描述：</span><span class="value">${work.作品描述 || '無描述'}</span></div>
        <div class="info-item"><span class="label">作品影片網址：</span><a href="${work['作品展示(youtube連結)']}" target="_blank" class="external-link">${work['作品展示(youtube連結)']}</a></div>
        <div class="info-item"><span class="label">作品程式碼網址：</span><a href="${work['程式碼(Github連結)']}" target="_blank" class="external-link">${work['程式碼(Github連結)']}</a></div>
    `;
    html += `</div></section>`;

    document.getElementById('teamContent').innerHTML = html;

        if(team.報名進度 === '完成報名') {
            const feedbackButton = document.createElement('button');
            feedbackButton.textContent = '查看評分';
            feedbackButton.className = 'feedback-btn';
            feedbackButton.onclick = () => {
                window.location.href = `teacher_viewfeedback.php?username=${encodeURIComponent(name)}`;
            };
            document.getElementById('teamContent').appendChild(feedbackButton);
        }
        else if(team.報名進度 === '送出報名') {
            const confirmButton = document.createElement('button');
            confirmButton.textContent = '確認報名';
            confirmButton.className = 'confirm-btn';
            confirmButton.onclick = async () => {
                const { error } = await supabaseClient
                    .from('隊伍')
                    .update({ 報名進度: '完成報名' })
                    .eq('隊伍編號', team.隊伍編號)
                    .eq('參加年份', team.參加年份);

                if (error) {
                    alert('確認報名失敗：' + error.message);
                } else {
                    alert('報名已確認！');
                    loadTeamdata(); // 重新載入資料
                }
            };
            const rejectButton = document.createElement('button');
            rejectButton.textContent = '退件';
            rejectButton.className = 'reject-btn';
            rejectButton.onclick = async () => {
                const { error } = await supabaseClient
                    .from('隊伍')
                    .update({ 報名進度: '退件' })
                    .eq('隊伍編號', team.隊伍編號)
                    .eq('參加年份', team.參加年份);

                if (error) {
                    alert('拒絕報名失敗：' + error.message);
                } else {
                    alert('報名已拒絕！');
                }
            };
            document.getElementById('teamContent').appendChild(confirmButton);
            document.getElementById('teamContent').appendChild(rejectButton);
        }
    }

    loadTeamdata();
    </script>
        <div class="return-section">
            <form action="teacher_dashboard.php" method="POST">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
                <button type="submit" class="return-btn">返回</button>
            </form>
        </div>
    </main>

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
