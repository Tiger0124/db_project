function navigate(system) {
    const content = document.getElementById('content');
    switch (system) {
      case 'admin':
        content.innerHTML = `
          <h2>管理員登入系統</h2>
          <form id="admin-login">
            <label for="username">用戶名</label>
            <input type="text" id="username" required>
            <label for="password">密碼</label>
            <input type="password" id="password" required>
            <button type="submit">登入</button>
          </form>
        `;
        document.getElementById('admin-login').addEventListener('submit', adminLogin);
        break;
        case 'student':
            content.innerHTML = `
              <h2>學生系統</h2>
              <p>請選擇功能：</p>
              <button onclick="showStudentLogin()">學生登入</button>
              <button onclick="showStudentRegister()">報名系統</button>
              <button onclick="showStudentHistory()">歷屆作品瀏覽</button>
              <div id="student-content"></div>
            `;
            break;
          
      case 'teacher':
      content.innerHTML = `
        <h2>指導老師系統</h2>
        <button onclick="viewTeacherWorks()">瀏覽指導學生作品</button>
        <div id="teacher-content"></div>
      `;
      break;
      case 'judge':
  content.innerHTML = `
    <h2>評審系統</h2>
    <button onclick="rateWork()">填寫評分</button>
    <button onclick="editRate()">修改評分</button>
    <div id="judge-content"></div>
  `;
  break;
    }
  }
  
  function adminLogin(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    if (username === 'admin' && password === '1234') {
      alert('登入成功！');
        adminDashboard();
    } else {
      alert('登入失敗，請檢查用戶名與密碼。');
    }
  }
  function showStudentLogin() {
    const studentContent = document.getElementById('student-content');
    studentContent.innerHTML = `
      <h3>學生登入</h3>
      <form id="student-login-form">
        <label for="student-username">用戶名</label>
        <input type="text" id="student-username" required>
        <label for="student-password">密碼</label>
        <input type="password" id="student-password" required>
        <button type="submit">登入</button>
      </form>
    `;
    document.getElementById('student-login-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const username = document.getElementById('student-username').value;
      const password = document.getElementById('student-password').value;
      if (username === 'admin' && password === '1234') {
        alert('登入成功！');
      } else {
        alert('登入失敗！');
      }
    });
  }
  
  function showStudentRegister() {
    const studentContent = document.getElementById('student-content');
    studentContent.innerHTML = `
      <h3>報名系統</h3>
      <form id="register-form">
        <label for="team-name">隊伍名稱</label>
        <input type="text" id="team-name" required>
        <label for="team-description">作品說明書</label>
        <textarea id="team-description" required></textarea>
        <button type="submit">提交報名</button>
      </form>
    `;
    document.getElementById('register-form').addEventListener('submit', (e) => {
      e.preventDefault();
      alert('報名成功！');
    });
  }
  
  function showStudentHistory() {
    const studentContent = document.getElementById('student-content');
    studentContent.innerHTML = `
      <h3>歷屆作品瀏覽</h3>
      <select id="year-select" onchange="loadWorks()">
        <option value="100">100 年</option>
        <option value="101">101 年</option>
        <option value="102">102 年</option>
      </select>
      <div id="works-list"></div>
    `;
  }
  
  function loadWorks() {
    const works = {
      100: [{ group: '隊伍A', description: '作品A說明書' }, { group: '隊伍B', description: '作品B說明書' }],
      101: [{ group: '隊伍C', description: '作品C說明書' }, { group: '隊伍D', description: '作品D說明書' }],
      102: [{ group: '隊伍E', description: '作品E說明書' }, { group: '隊伍F', description: '作品F說明書' }],
    };
    const year = document.getElementById('year-select').value;
    const worksList = document.getElementById('works-list');
    const selectedWorks = works[year] || [];
    worksList.innerHTML = selectedWorks.length
      ? selectedWorks.map((work) => `<p>${work.group}: ${work.description}</p>`).join('')
      : '<p>該年份沒有作品。</p>';
  }

  function viewTeacherWorks() {
    const teacherContent = document.getElementById('teacher-content');
    teacherContent.innerHTML = `
      <h3>指導學生作品</h3>
      <table border="1">
        <tr>
          <th>組別名稱</th>
          <th>作品說明書</th>
        </tr>
        <tr>
          <td>隊伍A</td>
          <td>作品A說明書</td>
        </tr>
        <tr>
          <td>隊伍B</td>
          <td>作品B說明書</td>
        </tr>
      </table>
    `;
  }

  function rateWork() {
    const judgeContent = document.getElementById('judge-content');
    judgeContent.innerHTML = `
      <h3>評分系統</h3>
      <form>
        <label for="group-name">組別名稱</label>
        <input type="text" id="group-name" required>
        <label for="score">分數</label>
        <input type="number" id="score" required>
        <button type="submit">提交</button>
      </form>
    `;
  }
  
  function editRate() {
    const judgeContent = document.getElementById('judge-content');
    judgeContent.innerHTML = `
      <h3>修改評分</h3>
      <p>組別A: 原分數 85</p>
      <p>組別B: 原分數 90</p>
      <form>
        <label for="new-score">組別A 新分數</label>
        <input type="number" id="new-score" required>
        <button type="submit">修改</button>
      </form>
    `;
  }

  function adminDashboard() {
    const content = document.getElementById('content');
    content.innerHTML = `
      <h2>歡迎，管理員！</h2>
      <p>請選擇以下功能：</p>
      <div class="admin-buttons">
        <button onclick="viewStudentData()">查詢學生資料</button>
        <button onclick="editStudentData()">修改報名資料</button>
        <button onclick="viewJudgeData()">查詢評審資料</button>
        <button onclick="viewScoreData()">查看評分資料</button>
        <button onclick="manageAnnouncements()">公告重要事項</button>
      </div>
      <div id="admin-content"></div>
    `;
  }
  
  function viewStudentData() {
    const adminContent = document.getElementById('admin-content');
    adminContent.innerHTML = `
      <h3>查詢學生資料</h3>
      <p>選擇年份：</p>
      <select id="student-year" onchange="loadStudentData()">
        <option value="100">100 年</option>
        <option value="101">101 年</option>
        <option value="102">102 年</option>
      </select>
      <div id="student-data"></div>
    `;
  }
  
  function loadStudentData() {
    const studentData = {
      100: [{ name: '學生A', id: '11001' }, { name: '學生B', id: '11002' }],
      101: [{ name: '學生C', id: '11003' }, { name: '學生D', id: '11004' }],
      102: [{ name: '學生E', id: '11005' }, { name: '學生F', id: '11006' }],
    };
    const year = document.getElementById('student-year').value;
    const data = studentData[year] || [];
    const studentDataDiv = document.getElementById('student-data');
    studentDataDiv.innerHTML = data.length
      ? `<table border="1">
           <tr><th>姓名</th><th>學號</th></tr>
           ${data.map(student => `<tr><td>${student.name}</td><td>${student.id}</td></tr>`).join('')}
         </table>`
      : '<p>該年份無學生資料。</p>';
  }
  
  function editStudentData() {
    const adminContent = document.getElementById('admin-content');
    adminContent.innerHTML = `
      <h3>修改報名資料</h3>
      <form>
        <label for="student-id">學生學號</label>
        <input type="text" id="student-id" required>
        <label for="new-team">新隊伍名稱</label>
        <input type="text" id="new-team" required>
        <button type="submit">修改</button>
      </form>
    `;
  }
  
  function viewJudgeData() {
    const adminContent = document.getElementById('admin-content');
    adminContent.innerHTML = `
      <h3>查詢評審資料</h3>
      <p>選擇年份：</p>
      <select id="judge-year" onchange="loadJudgeData()">
        <option value="100">100 年</option>
        <option value="101">101 年</option>
        <option value="102">102 年</option>
      </select>
      <div id="judge-data"></div>
    `;
  }
  
  function loadJudgeData() {
    const judgeData = {
      100: [{ name: '評審A', profession: '教授' }, { name: '評審B', profession: '工程師' }],
      101: [{ name: '評審C', profession: '設計師' }, { name: '評審D', profession: '企業家' }],
      102: [{ name: '評審E', profession: '研究員' }, { name: '評審F', profession: '律師' }],
    };
    const year = document.getElementById('judge-year').value;
    const data = judgeData[year] || [];
    const judgeDataDiv = document.getElementById('judge-data');
    judgeDataDiv.innerHTML = data.length
      ? `<table border="1">
           <tr><th>姓名</th><th>職業</th></tr>
           ${data.map(judge => `<tr><td>${judge.name}</td><td>${judge.profession}</td></tr>`).join('')}
         </table>`
      : '<p>該年份無評審資料。</p>';
  }
  
  function viewScoreData() {
    const adminContent = document.getElementById('admin-content');
    adminContent.innerHTML = `
      <h3>查看評分資料</h3>
      <p>選擇年份：</p>
      <select id="score-year" onchange="loadScoreData()">
        <option value="100">100 年</option>
        <option value="101">101 年</option>
        <option value="102">102 年</option>
      </select>
      <div id="score-data"></div>
    `;
  }
  
  function loadScoreData() {
    const scoreData = {
      100: [{ group: '隊伍A', score: '85' }, { group: '隊伍B', score: '90' }],
      101: [{ group: '隊伍C', score: '88' }, { group: '隊伍D', score: '92' }],
      102: [{ group: '隊伍E', score: '87' }, { group: '隊伍F', score: '89' }],
    };
    const year = document.getElementById('score-year').value;
    const data = scoreData[year] || [];
    const scoreDataDiv = document.getElementById('score-data');
    scoreDataDiv.innerHTML = data.length
      ? `<table border="1">
           <tr><th>組別名稱</th><th>分數</th></tr>
           ${data.map(score => `<tr><td>${score.group}</td><td>${score.score}</td></tr>`).join('')}
         </table>`
      : '<p>該年份無評分資料。</p>';
  }
  
  function manageAnnouncements() {
    const adminContent = document.getElementById('admin-content');
    adminContent.innerHTML = `
      <h3>公告重要事項</h3>
      <form id="announcement-form">
        <label for="announcement-title">標題</label>
        <input type="text" id="announcement-title" required>
        <label for="announcement-content">內容</label>
        <textarea id="announcement-content" required></textarea>
        <button type="submit">新增公告</button>
      </form>
      <div id="announcement-list"></div>
    `;
  
    document.getElementById('announcement-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const title = document.getElementById('announcement-title').value;
      const content = document.getElementById('announcement-content').value;
      const list = document.getElementById('announcement-list');
      list.innerHTML += `<p><strong>${title}</strong>: ${content}</p>`;
      document.getElementById('announcement-form').reset();
    });
  }
  
  