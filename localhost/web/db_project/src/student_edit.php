<!DOCTYPE html>
<html lang="zh-TW">
    <style>
        /* ===== Universal Dark Mode Styles ===== */
        body {
            background: #121826 !important;
            color: #7986a0 !important;
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

        main#content {
            background: linear-gradient(135deg, #0d1525 0%, #1a2439 100%) !important;
        }

        main h2 {
            color: #e0e4ec !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        }

        .rounded-box {
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4d7a 100%) !important;
            box-shadow: 0 15px 40px rgba(30, 58, 95, 0.4) !important;
        }

        .rounded-box:hover {
            box-shadow: 0 20px 50px rgba(30, 58, 95, 0.6) !important;
        }

        .system-button {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        .system-button:hover {
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
            background: #1a2439 !important;
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

        .form-group {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
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
        input[type="email"] {
            background: rgba(26, 36, 57, 0.8) !important;
            color: #e0e4ec !important;
            border: 2px solid #2a4d7a !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #3a6ea5 !important;
            background: rgba(30, 40, 60, 0.9) !important;
            box-shadow: 0 4px 15px rgba(58, 110, 165, 0.3) !important;
        }

        input::placeholder {
            color: #9aacd0 !important;
        }

        button[type="submit"] {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, #3a6ea5 0%, #2a4d7a 100%) !important;
            box-shadow: 0 12px 35px rgba(58, 110, 165, 0.6) !important;
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
    </style>
    <script>
        // Add toggle button and dark mode class
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('dark-mode');
            const navbar = document.querySelector('.navbar');
            if (navbar && !document.querySelector('.darkmode-btn')) {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'darkmode-btn';
                toggleBtn.innerHTML = '☀️ 切換亮色模式';
                toggleBtn.onclick = () => window.location.href = '?toggle_dm=1';
                navbar.appendChild(toggleBtn);
            }

            // Apply animations if they exist
            const animatedElements = document.querySelectorAll('.form-group, .student-info');
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改團隊成員資料</title>
    <link rel="stylesheet" href="../asset/student_edit.css">
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
        <h2>歡迎，stu2！</h2>            <section class="edit-team-section">
                <h2>修改團隊成員資料</h2>

                <!-- 學生資料切換按鈕 -->
                <div class="member-tabs">
                                                                        <button type="button" class="tab-btn active" data-member="0">
                                學生 1                            </button>
                                                    <button type="button" class="tab-btn " data-member="1">
                                學生 2                            </button>
                                                                                        <button type="button" class="tab-btn professor-tab" data-member="professor">
                            指導老師
                        </button>
                                    </div>

                <form action="student_update.php" method="POST" id="editForm">
                    <!-- 學生資料表單 -->
                                                                        <div class="member-form active" data-form="0">
                                <fieldset class="student-fieldset">
                                    <legend>學生 1 資料</legend>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student0-id">身分證字號：</label>
                                            <input type="text" id="student0-id" name="student0_id"
                                                value="A123456789" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="student0-studentid">學號：</label>
                                            <input type="text" id="student0-studentid"
                                                name="student0_studentid" value="A1115570"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student0-name">姓名：</label>
                                            <input type="text" id="student0-name" name="student0_name"
                                                value="admin" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student0-email">電子郵件：</label>
                                            <input type="email" id="student0-email" name="student0_email"
                                                value="new@mail.com" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student0-phone">電話：</label>
                                            <input type="tel" id="student0-phone" name="student0_phone"
                                                value="0099999999" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student0-department">科系：</label>
                                            <input type="text" id="student0-department"
                                                name="student0_department"
                                                value="CSIEe" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                                                    <div class="member-form " data-form="1">
                                <fieldset class="student-fieldset">
                                    <legend>學生 2 資料</legend>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student1-id">身分證字號：</label>
                                            <input type="text" id="student1-id" name="student1_id"
                                                value="A111      " required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="student1-studentid">學號：</label>
                                            <input type="text" id="student1-studentid"
                                                name="student1_studentid" value="stu2    "
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student1-name">姓名：</label>
                                            <input type="text" id="student1-name" name="student1_name"
                                                value="ck6" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student1-email">電子郵件：</label>
                                            <input type="email" id="student1-email" name="student1_email"
                                                value="newer@mail.com" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="student1-phone">電話：</label>
                                            <input type="tel" id="student1-phone" name="student1_phone"
                                                value="0888811111" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="student1-department">科系：</label>
                                            <input type="text" id="student1-department"
                                                name="student1_department"
                                                value="CSIP" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                                            
                    <!-- 指導老師資料表單 -->
                                            <div class="member-form" data-form="professor">
                            <fieldset class="professor-fieldset">
                                <legend>指導老師資料</legend>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="professor-id">身分證字號：</label>
                                        <input type="text" id="professor-id" name="professor_id"
                                            value="A123456789" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="professor-name">姓名：</label>
                                        <input type="text" id="professor-name" name="professor_name"
                                            value="李安潔" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="professor-email">電子郵件：</label>
                                        <input type="email" id="professor-email" name="professor_email"
                                            value="aaaaaaaa@mail.nuk.edu.tw" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="professor-phone">電話：</label>
                                        <input type="tel" id="professor-phone" name="professor_phone"
                                            value="0000000000" required>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    
                    <input type="hidden" name="team_id" value="T001">
                    <input type="hidden" name="username" value="stu2">
                    <input type="hidden" name="password" value="A111">
                    <input type="hidden" name="member_count" value="2">

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">提交修改</button>
                    </div>
                </form>

                <div class="return-section">
                    <form action="student_dashboard.php" method="POST">
                        <input type="hidden" name="username" value="stu2">
                        <input type="hidden" name="password" value="A111">
                        <button type="submit" class="return-btn">返回</button>
                    </form>
                </div>
            </section>

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

    <script src="student_edit.js"></script>
</body>

</html>