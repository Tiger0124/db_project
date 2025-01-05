<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
        <a href="main.php" alt="Logo" class="logo">
            <img src="images/logo.png" alt="Logo" class="logo">
        </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main>
        <section class="upload-section">
            <h2>提交作品資料</h2>
            <form action="submit_project.php" method="POST" enctype="multipart/form-data">
                <!-- 上傳說明書 -->
                <div class="form-group">
                    <label for="manual-upload">上傳說明書：</label>
                    <input type="file" id="manual-upload" name="manual_file" accept=".pdf,.doc,.docx" required>
                </div>

                <!-- 上傳海報 -->
                <div class="form-group">
                    <label for="poster-upload">上傳海報：</label>
                    <input type="file" id="poster-upload" name="poster_file" accept=".jpg,.png,.pdf" required>
                </div>

                <!-- 作品影片網址 -->
                <div class="form-group">
                    <label for="video-url">作品影片網址：</label>
                    <input type="url" id="video-url" name="video_url" placeholder="https://example.com/video" required>
                </div>

                <!-- 作品程式碼網址 -->
                <div class="form-group">
                    <label for="code-url">作品程式碼網址：</label>
                    <input type="url" id="code-url" name="code_url" placeholder="https://github.com/example" required>
                </div>

                <button type="submit">提交資料</button>
            </form>
        </section>
    </main>
    <form action="student_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
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
