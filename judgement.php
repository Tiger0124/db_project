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

    <main id="content">
        <section class="team-table">
            <h2>隊伍列表</h2>
            <table>
                <thead>
                    <tr>
                        <th>隊伍名稱</th>
                        <th>作品說明書</th>
                        <th>海報</th>
                        <th>影片網址</th>
                        <th>程式碼網址</th>
                        <th>評分</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 隊伍 1 -->
                    <!-- <tr>
                        <td>創新未來隊</td>
                        <td><a href="files/description1.pdf" download>下載說明書</a></td>
                        <td><a href="files/poster1.pdf" download>下載海報</a></td>
                        <td><a href="https://youtu.be/example1" target="_blank">影片連結</a></td>
                        <td><a href="https://github.com/example/project1" target="_blank">程式碼連結</a></td>
                        <td>
                            <form action="submit_score.php" method="POST">
                                <input type="number" id="score1" name="score1" min="1" max="100" required>
                        </td>
                        <td>
                                <button type="submit">提交評分</button>
                            </form>
                        </td>
                    </tr> -->
                    <!-- 隊伍 2 -->
                    <!-- <tr>
                        <td>未來之星隊</td>
                        <td><a href="files/description2.pdf" download>下載說明書</a></td>
                        <td><a href="files/poster2.pdf" download>下載海報</a></td>
                        <td><a href="https://youtu.be/example2" target="_blank">影片連結</a></td>
                        <td><a href="https://github.com/example/project2" target="_blank">程式碼連結</a></td>
                        <td>
                            <form action="submit_score.php" method="POST">
                                <input type="number" id="score2" name="score2" min="1" max="100" required>
                        </td>
                        <td>
                                <button type="submit">提交評分</button>
                            </form>
                        </td>
                    </tr> -->
                    <?php
                        include 'conn.php';
                        // 獲取當前年份
                        $currentYear = date("Y");
                        $select_db = @mysqli_select_db($link, "db_project"); //選擇資料庫
                        $sql = "SELECT 隊伍.隊伍編號, 隊伍.隊伍名稱, 作品.說明書, 作品.海報, 作品.作品展示_youtube連結, 作品.程式碼_Github連結 FROM 隊伍 natural join 作品 WHERE 隊伍.參加年份 = '$currentYear'";
                        $result = mysqli_query($link, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>".$row['隊伍名稱']."</td>";
                            echo "<td><a href='files/".$row['說明書']."' download>下載說明書</a></td>";
                            echo "<td><a href='files/".$row['海報']."' download>下載海報</a></td>";
                            echo "<td><a href='".$row['作品展示_youtube連結']."' target='_blank'>影片連結</a></td>";
                            echo "<td><a href='".$row['程式碼_Github連結']."' target='_blank'>程式碼連結</a></td>";
                            echo "<td>";
                            echo "<form action='submit_score.php' method='POST'>";
                            echo "<input type='number' id='score".$row['隊伍編號']."' name='score".$row['隊伍編號']."' min='1' max='100' required>";
                            echo "</td>";
                            echo "<td>";
                            echo "<button type='submit'>提交評分</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <form action="judge_dashboard.php" method="POST">
            <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <button type="submit">返回</button>
        </form>
    </main>
</body>
</html>
