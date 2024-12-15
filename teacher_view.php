<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師指導隊伍資料</title>
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
        <section class="team-info">
            <h2>指導的隊伍資訊</h2>
            
            <div class="team">
                <h3>隊伍名稱：創新未來隊</h3>
                <p><strong>作品說明書：</strong> 
                    <a href="files/description.pdf" download>下載說明書</a>
                </p>
                <p><strong>作品影片網址：</strong> 
                    <a href="https://example.com/project-video" target="_blank">https://example.com/project-video</a>
                </p>
                <p><strong>作品程式碼網址：</strong> 
                    <a href="https://github.com/example/project" target="_blank">https://github.com/example/project</a>
                </p>

                <h4>學生資料</h4>
                <table>
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>學號</th>
                            <th>身分證字號</th>
                            <th>科系</th>
                            <th>年級</th>
                            <th>電子郵件</th>
                            <th>電話</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>王小明</td>
                            <td>109123456</td>
                            <td>A123456789</td>
                            <td>資訊工程學系</td>
                            <td>四年級</td>
                            <td>example1@mail.com</td>
                            <td>0912345678</td>
                        </tr>
                        <tr>
                            <td>林美麗</td>
                            <td>109654321</td>
                            <td>B987654321</td>
                            <td>電子工程學系</td>
                            <td>四年級</td>
                            <td>example2@mail.com</td>
                            <td>0987654321</td>
                        </tr>
                        <tr>
                            <td>陳大華</td>
                            <td>109111111</td>
                            <td>C111111111</td>
                            <td>電機工程學系</td>
                            <td>三年級</td>
                            <td>example3@mail.com</td>
                            <td>0933333333</td>
                        </tr>
                    </tbody>
                </table>

                <h4>指導教授</h4>
                <table>
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>身分證字號</th>
                            <th>電子郵件</th>
                            <th>電話</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>張教授</td>
                            <td>D123456789</td>
                            <td>professor@mail.com</td>
                            <td>0988123456</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <form action="teacher_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
        <button type="submit">返回</button>
    </form>
</body>
</html>
