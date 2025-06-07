    <style>
        /* ===== Universal Dark Mode Styles ===== */
        body {
            background: #121826 !important;
            color: #e0e4ec !important;
        }

        header {
            background: linear-gradient(to right,
                    #2a3a55 0%,
                    #2a3a55 30%,
                    #1e3a5f 60%,
                    #1e3a5f 100%) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
        }

        header h1 {
            color: #ffffff !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8) !important;
        }

        main,
        main#content {
            background: linear-gradient(135deg, #0d1525 0%, #1a2439 100%) !important;
        }

        h2,
        main h2 {
            color: rgb(84, 91, 145) !important;
            background: #1a2439 !important;
            border-left: 4px solid rgb(84, 91, 145) !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        }

        .rounded-box {
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4d7a 100%) !important;
            box-shadow: 0 15px 40px rgba(30, 58, 95, 0.4) !important;
        }

        .rounded-box:hover {
            box-shadow: 0 20px 50px rgba(30, 58, 95, 0.6) !important;
        }

        .buttons,
        .system-button,
        .admin-buttons button {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        .system-button:hover,
        .admin-buttons button:hover {
            background: linear-gradient(135deg, #3a6ea5 0%, #2a4d7a 100%) !important;
            box-shadow: 0 12px 35px rgba(58, 110, 165, 0.6) !important;
            color: white !important;
            border-color: #3a6ea5 !important;
        }

        table {
            background: #1a2439 !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
        }

        thead th {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
        }

        tbody td {
            color: #d0d8e8 !important;
            border-bottom: 1px solid #2a3a55 !important;
        }

        tbody tr:hover {
            background-color: #222e45 !important;
        }

        a[download] {
            background: linear-gradient(135deg, #3a6ea5 0%, #2a4d7a 100%) !important;
            box-shadow: 0 6px 20px rgba(42, 77, 122, 0.5) !important;
        }

        a[download]:hover {
            box-shadow: 0 10px 30px rgba(42, 77, 122, 0.7) !important;
        }

        .site-footer {
            background: #1a2439 !important;
        }

        .footer-links li a:hover {
            color: #3a6ea5 !important;
        }

        /* ===== Form Page Specific Styles ===== */
        form {
            border-radius: 20px !important;
            background: rgb(63, 73, 143) !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3) !important;
        }

        form:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4) !important;
        }

        h3 {
            color: #4caf50 !important;
            border-bottom: 3px solid #4caf50 !important;
        }

        h3::before {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
        }

        .member-btn {
            background: linear-gradient(135deg, #2a3a55 0%, #1a2439 100%) !important;
            color: #d0d8e8 !important;
            border: 2px solid #2a3a55 !important;
        }

        .member-btn.active {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(42, 77, 122, 0.3) !important;
        }

        .member-btn.optional {
            background: linear-gradient(135deg, #3a1b6a 0%, #2a0a5a 100%) !important;
            color: #d0d8e8 !important;
        }

        .member-btn.optional.active {
            background: linear-gradient(135deg, #4a2b8a 0%, #3a1b6a 100%) !important;
            box-shadow: 0 4px 15px rgba(74, 43, 138, 0.3) !important;
        }

        .container,
        .team-info,
        .form-group {
            border-radius: 10px;
            padding: 0.8rem 1rem;

            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        .form-group textarea,
        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group input[type="url"],
        .form-group input[type="password"] {
            background: rgba(26, 36, 57, 0.8) !important;
        }

        .form-group textarea:focus,
        .form-group input[type="text"]:focus,
        .form-group input[type="file"]:focus,
        .form-group input[type="url"]:focus,
        .form-group input[type="password"]:focus {
            background: rgba(26, 36, 57, 0.8) !important;
        }

        .container {
            background-color: #2a3a55 !important;
        }

        .team-table {
            background: #2a3a55 !important;
        }



        .student-info {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        .student-info.optional-member {
            background: linear-gradient(135deg, #3a1b6a 0%, #2a0a5a 100%) !important;
            box-shadow: 0 8px 25px rgba(58, 27, 106, 0.4) !important;
        }

        h4,
        label {
            color: #e0e4ec !important;
        }

        .required-badge {
            background: rgba(220, 53, 69, 0.7) !important;
        }

        .optional-badge {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #e0e4ec !important;
        }

        input[type="text"],
        input[type="url"],
        input[type="password"],
        input[type="file"],
        input[type="tel"],
        input[type="email"] {
            background: rgba(26, 36, 57, 0.8) !important;
            color: #e0e4ec !important;
            border: 2px solid #2a4d7a !important;
        }

        input::placeholder {
            color: #9aacd0 !important;
        }

        button,
        input[type="submit"],
        button[type="submit"] {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: rgb(147, 138, 213) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, #3a6ea5 0%, #2a4d7a 100%) !important;
            box-shadow: 0 12px 35px rgba(58, 110, 165, 0.6) !important;
        }

        /* ===== Admin Page Specific Styles ===== */
        .content-wrapper {
            background: #1a2439 !important;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3) !important;
        }

        .admin-buttons {

            background: linear-gradient(135deg, #1e3a5f 0%, #2a4d7a 100%) !important;
            box-shadow: 0 15px 40px rgba(30, 58, 95, 0.4) !important;
        }

        .admin-buttons:hover {
            box-shadow: 0 20px 50px rgba(30, 58, 95, 0.6) !important;
        }

        body>h2 {
            background: #1a2439 !important;
            color: rgb(84, 91, 145) !important;
            border-left: 4px solidrgb(74, 65, 121) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        }

        body>p {
            background: #1a2439 !important;
            color: #e0e4ec !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
        }

        .result-container {
            background: #1a2439 !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3) !important;
            color: #e0e0e0 !important;
            animation: fadeInUp 0.6s ease-out !important;
        }

        .student-fieldset {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        .professor-fieldset {
            background: linear-gradient(135deg, #3a1b6a 0%, #2a0a5a 100%) !important;
            box-shadow: 0 8px 25px rgba(58, 27, 106, 0.4) !important;
        }

        fieldset:hover {
            box-shadow: 0 10px 30px rgba(30, 58, 95, 0.5) !important;
        }

        .professor-fieldset:hover {
            box-shadow: 0 10px 30px rgba(58, 27, 106, 0.5) !important;
        }


        /* Preserve animations */
        .upload-section {
            animation: fadeInUp 0.6s ease-out !important;
        }

        .upload-section {
            background: #1a2439 !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3) !important;
        }

        .upload-section h2 {
            color: #e0e0e0 !important;
        }


        .rounded-box,
        .edit-team-section,
        .error-section {
            background: #1a2439 !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3) !important;
        }

        .rounded-box:hover,
        .edit-team-section:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4) !important;
        }

        /* ===== Toggle Button - Light Mode Style ===== */
        .darkmode-btn {
            margin-left: auto;
            padding: 10px 20px !important;
            background: linear-gradient(135deg, #FFD700 0%, #f5be11 100%) !important;
            color: #2c3e50 !important;
            border: none !important;
            border-radius: 50px !important;
            cursor: pointer !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            box-shadow: 0 4px 15px rgba(245, 190, 17, 0.4) !important;
            transition: all 0.3s ease !important;
            text-align: center;
        }

        .darkmode-btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 20px rgba(245, 190, 17, 0.6) !important;
        }




        .return-section {
            /* padding: 10px; */
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4d7a 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }
    </style>
    <script>
        // Add toggle button and animations
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar && !document.querySelector('.darkmode-btn')) {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'darkmode-btn';
                toggleBtn.innerHTML = '☀️ 切換亮色模式';
                toggleBtn.onclick = () => window.location.href = '?toggle_dm=1';
                navbar.appendChild(toggleBtn);
            }

            // Apply animations if they exist
            const animatedElements = document.querySelectorAll(
                '.form-group, .student-info, .admin-buttons,.edit-team-section, h2');
            if (animatedElements.length > 0) {
                animatedElements.forEach(el => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                });

                setTimeout(() => {
                    animatedElements.forEach(el => {
                        el.style.transition = 'all 0.6s ease-out';
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    });
                }, 100);
            }
        });
    </script>
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

    <div class="return-section">
      <button onclick="goBack()" class="return-btn">
        返回
      </button>
    </div>

    <script>
      const {
        createClient
      } = supabase;
      const supabaseClient = createClient(
        'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
      );

      // ✅ 把 PHP 中的帳號與身分證帶進 JS
      const userId = "a";
      const username = "a";
      console.log('userId:', userId);

      async function loadProfile() {
        const {
          data,
          error
        } = await supabaseClient
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

      document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const updates = {
          姓名: document.getElementById('name').value,
          電話: document.getElementById('phone').value,
          電子郵件: document.getElementById('email').value,
          職稱: document.getElementById('title').value,
        };

        const {
          error
        } = await supabaseClient
          .from('指導老師')
          .update(updates)
          .eq('身分證字號', userId);

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