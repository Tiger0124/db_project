<?php include 'darkmode.php'; ?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/register_team.css">
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
    <?php
    // 引入資料庫連線 (包含 Supabase 客戶端設定)
    include 'conn.php'; // 假設 conn.php 檔案中已設定好 $supabaseClient

    // 檢查表單是否以 POST 提交
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentYear = date("Y");
        $yearToSession = [
            2013 => "1",
            2014 => "2",
            2015 => "3",
            2016 => "4",
            2017 => "5",
            2018 => "6",
            2019 => "7",
            2020 => "8",
            2021 => "9",
            2022 => "10",
            2023 => "11",
            2024 => "12",
            2025 => "13"
        ];
        $session = $yearToSession[$currentYear];

        // 查詢當前最大隊伍編號
        try {
            $response = $supabaseClient->get('隊伍', [
                'query' => [
                    'select' => '隊伍編號',
                    'order' => '隊伍編號.desc', // 降序排列
                    'limit' => 1
                ]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            $max_id = null;
            if (!empty($data) && isset($data[0]['隊伍編號'])) {
                $max_id = $data[0]['隊伍編號'];
            }
        } catch (GuzzleHttp\Exception\RequestException $e) {
            die("查詢最大隊伍編號失敗：" . $e->getMessage());
        }

        // 解析並生成下一個編號
        $next_num = 1;
        if ($max_id) {
            $next_num = (int)substr($max_id, 1) + 1; // 提取數字部分並加 1
        }
        $team_num = 'T' . str_pad($next_num, 3, '0', STR_PAD_LEFT); // 補齊 3 位數

        // 隊伍資料
        $team_name = $_POST['team_name'];

        // 插入隊伍資料
        try {
            $supabaseClient->post('隊伍', [
                'json' => [
                    '參加年份' => $currentYear,
                    '隊伍編號' => $team_num,
                    '隊伍名稱' => $team_name,
                    '名次' => null,
                    '屆數' => $session,
                    '報名進度' => '未送件',
                    '身分證字號' => $_POST['professor_id'],
                ]
            ]);
        } catch (GuzzleHttp\Exception\RequestException $e) {
            die("隊伍資料插入失敗：" . $e->getMessage());
        }

        // 學生資料
        for ($i = 1; $i <= 4; $i++) {
            $student_id = $_POST["student{$i}_id"] ?? null;
            $student_num = $_POST["student{$i}_num"] ?? null;
            $student_name = $_POST["student{$i}_name"] ?? null;
            $student_email = $_POST["student{$i}_email"] ?? null;
            $student_phone = $_POST["student{$i}_phone"] ?? null;
            $student_department = $_POST["student{$i}_department"] ?? null;

            // 如果是學生 4，檢查是否有輸入資料，若無則跳過
            if ($i > 1 && empty($student_id) && empty($student_num) && empty($student_name)) {
                continue;
            }

            // 檢查是否有該學號的學生存在
            try {
                $response = $supabaseClient->get("學生", [
                    'query' => [
                        '學號' => "eq.$student_num"
                    ]
                ]);
                $data = json_decode($response->getBody(), true);

                if (empty($data)) {
                    echo "alert('學號 {$student_num} 有誤，找不到此學生資料');";
                    echo "window.history.back();";
                    echo '</script>';
                    exit;
                }

                // 更新學生資料
                $supabaseClient->patch('學生', [
                    'query' => ['學號' => "eq.$student_num"],
                    'json' => [
                        '參加年份' => $currentYear,
                        '隊伍編號' => $team_num
                    ]
                ]);
            } catch (GuzzleHttp\Exception\RequestException $e) {
                die("學生資料更新失敗：" . $e->getMessage());
            }
        }

        // 更新指導老師指導的隊伍
        $professor_id = $_POST['professor_id'];
        $supabaseClient->patch('指導老師', [
            'query' => ['身份證字號' => "eq.$professor_id"],
            'json' => [
                '隊伍編號' => $team_num
            ]
        ]);

        // 報名成功訊息
        echo "<h2>報名成功！</h2>";
        echo "<p>隊伍編號：$team_num</p>";
        echo '
            <form action="student_dashboard.php" method="POST">
                <input type="hidden" name="username" value="' . $_POST['username'] . '">
                <input type="hidden" name="password" value="' . $_POST['password'] . '">
                <button type="submit">返回</button>
            </form>';
    } else {
        // 如果不是 POST 提交，跳轉回表單頁面
        header('Location: main.php');
        exit();
    }
    ?>
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