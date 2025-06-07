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

        textarea,
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
            background: rgba(167, 53, 220, 0.7) !important;
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


        button,
        input[type="submit"],
        button[type="submit"] {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: rgb(147, 138, 213) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        a[download] {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 12px 24px 12px 18px !important;
            margin: 8px 0 !important;
            font-family: 'Segoe UI', Roboto, sans-serif !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
            text-decoration: none !important;
            background-color: #f8f9fa !important;
            border: 2px solid #e9ecef !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05) !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            cursor: pointer !important;
        }

        .edit-button,
        .delete_btn {
            display: inline-block !important;
            padding: 6px 6px !important;
            font-family: 'Arial', sans-serif !important;
            font-size: 16px !important;
            font-weight: bold !important;
            color: rgb(47, 37, 112) !important;
            text-align: center !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            background: linear-gradient(135deg, #6e8efb, #a777e3) !important;
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
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

        .label,
        .download-link,
        .external-link,
        .upload-section h2 {
            color: #e0e0e0 !important;
            background: none !important;
        }

        thead th,
        table tr:first-child th {
            border-radius: 10px;

            background: linear-gradient(135deg, rgb(130, 5, 141) 0%, rgb(98, 35, 200) 100%) !important;
            color: rgb(168, 188, 232) !important;
        }

        tbody,
        tr,
        td {
            border-radius: 10px !important;

        }

        tbody:hover,
        tr:hover,
        td:hover {
            background: linear-gradient(135deg, rgb(23, 0, 26) 0%, rgb(24, 0, 63) 100%) !important;


        }


        .rounded-box::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgb(87, 37, 174) 0%, rgb(25, 4, 108) 100%) !important;
            border-radius: 4px;
        }

        .download-link,
        .external-link {
            background: none !important;
        }

        .team-info h2::before {
            background: #1a2439 !important;

        }

        .announcement-section,
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



        .edit-form,
        .return-section {
            border-radius: 20px !important;
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
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/announcements.css">
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
    <section class="announcement-section">
      <h2>發布公告</h2>
      <form action="post_announcement.php" method="POST" enctype="multipart/form-data">
        <!-- 公告標題 -->
        <label for='announcement-content'>公告內容：</label><textarea id='announcement-content' name='announcement_content' rows='5' required>哈哈明年再來，我是吳俊興，嘿，加油吧
</textarea><label for='competition-rules'>比賽規則：</label><textarea id='competition-rules' name='competition_rules' rows='5' required>猜得到算你贏，猜，很好</textarea><label for='announcement-file'>上傳檔案：</label><input type='file' id='announcement-file' name='announcement_file' accept='.pdf'>
        <!-- 提交按鈕 -->
        <button type="submit">發布公告</button>
        <input type="hidden" name="username" value="5543">
        <input type="hidden" name="password" value="5543">
      </form>
    </section>

    <form action="admin_dashboard.php" method="POST">
      <input type="hidden" name="username" value="5543">
      <input type="hidden" name="password" value="5543">
      <button type="submit">返回</button>
    </form>
  </main>
</body>
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

</html>