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

  <main id="content">
    <section class="announcement-section">
      <h2>發布公告</h2>
      <form action="post_announcement.php" method="POST" enctype="multipart/form-data">
        <!-- 公告標題 -->
        <label for="announcement-title">公告標題：</label>
        <input type="text" id="announcement-title" name="announcement_title" placeholder="請輸入公告標題" required>
        
        <!-- 公告內容 -->
        <label for="announcement-content">公告內容：</label>
        <textarea id="announcement-content" name="announcement_content" placeholder="請輸入公告內容" rows="5" required></textarea>
        
        <!-- 檔案上傳 -->
        <label for="file-upload">附加檔案：</label>
        <input type="file" id="file-upload" name="uploaded_file">
        
        <!-- 提交按鈕 -->
        <button type="submit">發布公告</button>
      </form>
    </section>
  </main>
  <form action="admin_dashboard.php" method="POST">
            <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <button type="submit">返回</button>
        </form>
</body>
</html>
