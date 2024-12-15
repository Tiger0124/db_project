<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統 - 隊伍列表與評分</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main>
        <section class="team-list">
            <h2>隊伍列表</h2>

            <!-- 隊伍 1 -->
            <div class="team">
                <h3>隊伍名稱：創新未來隊</h3>
                <p><strong>作品說明書：</strong> 
                    <a href="files/description1.pdf" download>下載說明書</a>
                </p>
                <p><strong>海報：</strong> 
                    <a href="files/poster1.pdf" download>下載海報</a>
                </p>
                <p><strong>作品影片網址：</strong> 
                    <a href="https://youtu.be/example1" target="_blank">https://youtu.be/example1</a>
                </p>
                <p><strong>作品程式碼網址：</strong> 
                    <a href="https://github.com/example/project1" target="_blank">https://github.com/example/project1</a>
                </p>
                <div class="score-section">
                    <form action="submit_score.php" method="POST">
                        <label for="score1">評分 (1-100)：</label>
                        <input type="number" id="score1" name="score1" min="1" max="100" required>
                        <button type="submit">提交評分</button>
                    </form>
                </div>
            </div>

            <!-- 隊伍 2 -->
            <div class="team">
                <h3>隊伍名稱：未來之星隊</h3>
                <p><strong>作品說明書：</strong> 
                    <a href="files/description2.pdf" download>下載說明書</a>
                </p>
                <p><strong>海報：</strong> 
                    <a href="files/poster2.pdf" download>下載海報</a>
                </p>
                <p><strong>作品影片網址：</strong> 
                    <a href="https://youtu.be/example2" target="_blank">https://youtu.be/example2</a>
                </p>
                <p><strong>作品程式碼網址：</strong> 
                    <a href="https://github.com/example/project2" target="_blank">https://github.com/example/project2</a>
                </p>
                <div class="score-section">
                    <form action="submit_score.php" method="POST">
                        <label for="score2">評分 (1-100)：</label>
                        <input type="number" id="score2" name="score2" min="1" max="100" required>
                        <button type="submit">提交評分</button>
                    </form>
                </div>
            </div>
        </section>
        <from action="judge_dashboard.php" method="POST">
            <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <button type="submit">返回</button>
        </form>
    </main>
</body>
</html>
