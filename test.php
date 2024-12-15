<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學激發學生創意競賽管理系統</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="navbar">
      <img src="images/logo.png" alt="Logo" class="logo">
      <h1>高雄大學激發學生創意競賽管理系統</h1>
    </div>
    <nav>
      <button onclick="navigate('admin')">管理員系統</button>
      <button onclick="navigate('student')">學生系統</button>
      <button onclick="navigate('teacher')">指導老師系統</button>
      <button onclick="navigate('judge')">評審系統</button>
    </nav>
  </header>
  <main id="content">
    <!-- 動態載入內容區域 -->
  </main>
  <script src="script.js"></script>
</body>
</html>

