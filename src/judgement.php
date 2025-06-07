<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統 - 隊伍列表與評分</title>
    <link rel="stylesheet" href="../asset/judgement.css">
    
    <script>
    src = "https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2.0.0/dist/umd/supabase.min.js";
    function goBack() {
        const form = document.createElement("form");
        form.method = "post";
        form.action = "judge_dashboard.php";

        form.innerHTML = `
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
        `;
        document.body.appendChild(form);
        form.submit();
    }
    </script>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" class="logo">
                <img src="../images/logo.png" alt="Logo" class="logo">
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
                            <th>作品名稱</th>
                            <th>作品說明書</th>
                            <th>海報</th>
                            <th>影片網址</th>
                            <th>程式碼網址</th>
                            <th>創意性</th>
                            <th>實用性</th>
                            <th>完整性</th>
                            <th>評語</th>
                        </tr>
                    </thead>
                    <tbody>
                    <form action="submit_score.php" method="POST">
                        <?php
                        include 'conn.php';
                        $currentYear = date("Y");
                        $reviewerId = $_POST["username"] ?? ""; // 評審的身分證字號（可依實際變數名稱）

                        // 年份對應屆數
                        $yearToSession = [
                            2013 => "1", 2014 => "2", 2015 => "3", 2016 => "4",
                            2017 => "5", 2018 => "6", 2019 => "7", 2020 => "8",
                            2021 => "9", 2022 => "10", 2023 => "11", 2024 => "12",
                            2025 => "13"
                        ];
                        $session = $yearToSession[$currentYear] ?? null;
                        
                        if (!$session) {
                            echo "<script>alert('無效的年度，無法對應屆數'); history.back();</script>";
                            exit;
                        }

                        // 查詢該評審是否屬於當屆
                        $reviewerRes = $supabaseClient->get("評審委員?身分證字號=eq.$reviewerId&select=屆數");
                        $reviewers = json_decode($reviewerRes->getBody(), true);

                        // 找不到該評審
                        if (empty($reviewers)) {
                            echo "<script>alert('查無此評審'); goBack();</script>";
                            exit;
                        }

                        // 檢查屆數是否相符
                        if ($reviewers[0]['屆數'] !== $session) {
                            echo "<script>alert('您不是本屆評審，無法評分'); goBack();</script>";
                            exit;
                        }

                        // 查詢所有今年的隊伍
                        $teamsResponse = $supabaseClient->get("隊伍?參加年份=eq.$currentYear");
                        $teams = json_decode($teamsResponse->getBody(), true);

                        // 取得評分資料（只抓該評審的）
                        $scoreResponse = $supabaseClient->get("評分資料?身分證字號=eq.$reviewerId");
                        $scoreData = json_decode($scoreResponse->getBody(), true);

                        // 建立 [隊伍編號] => true 的 map（該評審已評過的隊伍）
                        $scoredTeamMap = [];
                        foreach ($scoreData as $score) {
                            $scoredTeamMap[$score['隊伍編號']] = true;
                        }

                        // 過濾出尚未被評分的隊伍
                        $unscoredTeams = array_filter($teams, function ($team) use ($scoredTeamMap) {
                            return !isset($scoredTeamMap[$team['隊伍編號']]);
                        });

                        if (empty($unscoredTeams)) {
                            echo "<script>alert('您已評分所有隊伍'); goBack();</script>";
                            exit;
                        }

                        // 查詢所有作品
                        $worksResponse = $supabaseClient->get("作品");
                        $works = json_decode($worksResponse->getBody(), true);

                        // 建立作品 map
                        $workMap = [];
                        foreach ($works as $work) {
                            $workMap[$work['隊伍編號']] = $work;
                        }
                        ?>
                        <?php foreach ($unscoredTeams as $team): ?>
                            <?php $work = $workMap[$team['隊伍編號']] ?? null; ?>
                            <tr>
                                <td><?= htmlspecialchars($team['隊伍名稱']) ?></td>
                                <td><?= htmlspecialchars($work['作品名稱'] ?? '無') ?></td>

                                <!-- 說明書 -->
                                <td>
                                    <?php if (!empty($work['說明書'])): ?>
                                        <?php $pdf = base64_encode($work['說明書']); ?>
                                        <a href="data:application/pdf;base64,<?= $pdf ?>" download>下載</a>
                                    <?php else: ?>
                                        無
                                    <?php endif; ?>
                                </td>

                                <!-- 海報 -->
                                <td>
                                    <?php if (!empty($work['海報'])): ?>
                                        <?php $pdf = base64_encode($work['海報']); ?>
                                        <a href="data:application/pdf;base64,<?= $pdf ?>" download>下載</a>
                                    <?php else: ?>
                                        無
                                    <?php endif; ?>
                                </td>

                                <!-- YouTube 連結 -->
                                <td>
                                    <?php if (!empty($work['作品展示(youtube連結)'])): ?>
                                        <a href="<?= htmlspecialchars($work['作品展示(youtube連結)']) ?>" target="_blank">觀看</a>
                                    <?php else: ?>
                                        無
                                    <?php endif; ?>
                                </td>

                                <!-- GitHub 連結 -->
                                <td>
                                    <?php if (!empty($work['程式碼(Github連結)'])): ?>
                                        <a href="<?= htmlspecialchars($work['程式碼(Github連結)']) ?>" target="_blank">查看</a>
                                    <?php else: ?>
                                        無
                                    <?php endif; ?>
                                </td>

                                <!-- 評分輸入 - 創意性 -->
                                <td>
                                    <input type="number" name="scores_new[<?= $team['隊伍編號'] ?>]" placeholder="1-100" min="1" max="100" required>
                                    <input type="hidden" name="team_ids[<?= $team['隊伍編號'] ?>]" value="<?= $team['隊伍編號'] ?>">
                                    <input type="hidden" name="sessions[<?= $team['隊伍編號'] ?>]" value="<?= $team['屆數'] ?>">
                                    <input type="hidden" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                                    <input type="hidden" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>">
                                </td>

                                <!-- 評分輸入 - 實用性 -->
                                <td>
                                    <input type="number" name="scores_use[<?= $team['隊伍編號'] ?>]" placeholder="1-100" min="1" max="100" required>
                                </td>

                                <!-- 評分輸入 - 完整性 -->
                                <td>
                                    <input type="number" name="scores_integrity[<?= $team['隊伍編號'] ?>]" placeholder="1-100" min="1" max="100" required>
                                </td>

                                <!-- 評語輸入 -->
                                <td>
                                    <input type="text" name="comments[<?= $team['隊伍編號'] ?>]" placeholder="請輸入評語" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="text-align: right;">
                    <button type="submit" id="count_rank">提交評分</button>
                </div>
                </form>
                <script>
                document.getElementById('count_rank').addEventListener('click', function(event) {
                    if (!confirm('確定要提交評分嗎？')) {
                        event.preventDefault();
                    }
                });
                </script> 
        </section>
        <form action="judge_dashboard.php" method="POST">
            <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
            <button type="submit">返回</button>
        </form>
    </main>
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