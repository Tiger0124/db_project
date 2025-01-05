<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統 - 評分確認</title>
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
    <?php
    include 'conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $scores = $_POST['scores']; // 所有評分
        $teamIds = $_POST['team_ids']; // 隊伍編號
        $sessions = $_POST['sessions']; // 屆數
        $username = $_POST['username']; // 評審帳號
        $judgeId = $_POST['judge_id']; // 評審身分證(密碼)


        $currentYear = date("Y");

        foreach ($scores as $teamId => $score) {
            $session = $sessions[$teamId]; // 取得對應屆數
            // 將評分資料插入資料庫
            $sql = "INSERT INTO 評分資料 (評分, 參加年份, 隊伍編號, 身分證字號, 屆數) 
                    VALUES ('$score', '$currentYear', '$teamId', '$judgeId', '$session')";

            if (mysqli_query($link, $sql)) {
                echo "<h2>隊伍 $teamId 的評分已成功提交！<br>";
            } else {
                echo "<h2>隊伍 $teamId 的評分提交失敗：" . mysqli_error($link) . "<br>";
            }
        }
    }
    ?>
    <form action="judge_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $judgeId; ?>">
        <button type="submit">返回</button>
    </form>
</body>
