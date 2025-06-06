<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/view_students.css">
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
    <form action="view_students.php" method="POST">
        <select name="year">
          <option value="2013">2013</option>
          <option value="2014">2014</option>
          <option value="2015">2015</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>
        <button type="submit">查詢</button>
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
        <input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
    </form>
    <div class="rounded-box">
      <table style="width:100% ">
          <tr>
              <th>隊伍名稱</th>
              <th>指導老師</th>
              <th>學生名單</th>
              <th>作品名稱</th>
              <th>作品描述</th>
          </tr>
          <?php
session_start();
require_once 'conn.php';

// 年份到屆數的對應陣列
$yearToSession = [
    2013 => "第1屆", 2014 => "第2屆", 2015 => "第3屆", 2016 => "第4屆",
    2017 => "第5屆", 2018 => "第6屆", 2019 => "第7屆", 2020 => "第8屆",
    2021 => "第9屆", 2022 => "第10屆", 2023 => "第11屆", 2024 => "第12屆",
    2025 => "第13屆"
];

// 檢查是否有提交表單並且選擇的年份是有效的
if (isset($_POST['year']) && array_key_exists($_POST['year'], $yearToSession)) {
    $selectedYear = $_POST['year'];

    try {
        // 第一步：查詢隊伍資料
        $response = $supabaseClient->get('隊伍', [
            'query' => [
                '參加年份' => 'eq.' . $selectedYear,
                'select' => '*',
            ]
        ]);

        $status_code = $response->getStatusCode();
        
        if ($status_code == 200) {
            $teamsData = json_decode($response->getBody()->getContents(), true);

            if (!empty($teamsData)) {
                foreach ($teamsData as $row) {
                    echo "<tr>";
                    
                    // 隊伍名稱
                    $team_name = isset($row['隊伍名稱']) ? htmlspecialchars($row['隊伍名稱'], ENT_QUOTES, 'UTF-8') : 'N/A';
                    echo "<td>" . $team_name . "</td>";
                    
                    // 取得隊伍編號
                    $team_id = isset($row['隊伍編號']) ? $row['隊伍編號'] : null;
                    
                    // 查詢指導老師 - 使用隊伍編號
                    $teacher_name = 'N/A';
                    if ($team_id !== null) {
                        try {
                            $teacherResponse = $supabaseClient->get('指導老師', [
                                'query' => [
                                    '隊伍編號' => 'eq.' . $team_id,
                                    'select' => '姓名',
                                ]
                            ]);
                            
                            if ($teacherResponse->getStatusCode() == 200) {
                                $teacherData = json_decode($teacherResponse->getBody()->getContents(), true);
                                if (!empty($teacherData)) {
                                    $teacher_name = htmlspecialchars($teacherData[0]['姓名'], ENT_QUOTES, 'UTF-8');
                                }
                            }
                        } catch (Exception $e) {
                            // 查詢指導老師失敗，保持 N/A
                        }
                    }
                    echo "<td>" . $teacher_name . "</td>";
                    
                    // 查詢學生資料 - 使用隊伍編號
                    $students_display = 'N/A';
                    if ($team_id !== null) {
                        try {
                            $studentResponse = $supabaseClient->get('學生', [
                                'query' => [
                                    '隊伍編號' => 'eq.' . $team_id,
                                    'select' => '姓名',
                                ]
                            ]);
                            
                            if ($studentResponse->getStatusCode() == 200) {
                                $studentData = json_decode($studentResponse->getBody()->getContents(), true);
                                if (!empty($studentData)) {
                                    $student_names = [];
                                    foreach ($studentData as $student) {
                                        $student_names[] = htmlspecialchars($student['姓名'], ENT_QUOTES, 'UTF-8');
                                    }
                                    $students_display = implode(', ', $student_names);
                                }
                            }
                        } catch (Exception $e) {
                            // 查詢學生失敗，保持 N/A
                        }
                    }
                    echo "<td>" . $students_display . "</td>";
                    
                    // 查詢作品資料 - 使用隊伍編號
                    $project_name = 'N/A';
                    $project_description = 'N/A';
                    if ($team_id !== null) {
                        try {
                            $projectResponse = $supabaseClient->get('作品', [
                                'query' => [
                                    '隊伍編號' => 'eq.' . $team_id,
                                    'select' => '作品名稱,作品描述',
                                ]
                            ]);
                            
                            if ($projectResponse->getStatusCode() == 200) {
                                $projectData = json_decode($projectResponse->getBody()->getContents(), true);
                                if (!empty($projectData)) {
                                    $project_name = htmlspecialchars($projectData[0]['作品名稱'], ENT_QUOTES, 'UTF-8');
                                    $project_description = htmlspecialchars($projectData[0]['作品描述'], ENT_QUOTES, 'UTF-8');
                                }
                            }
                        } catch (Exception $e) {
                            // 查詢作品失敗，保持 N/A
                        }
                    }
                    echo "<td>" . $project_name . "</td>";
                    echo "<td>" . $project_description . "</td>";
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>查無 " . htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8') . " 年度的隊伍資料。</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>查詢隊伍資料失敗，HTTP 狀態碼：" . $status_code . "</td></tr>";
        }
    } catch (GuzzleHttp\Exception\RequestException $e) {
        echo "<tr><td colspan='5'>Guzzle 請求錯誤: ";
        if ($e->hasResponse()) {
            echo htmlspecialchars($e->getResponse()->getBody()->getContents(), ENT_QUOTES, 'UTF-8');
        } else {
            echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
        echo "</td></tr>";
    } catch (Exception $e) {
        echo "<tr><td colspan='5'>執行查詢時發生例外狀況: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
    }
}
?>


      </table>
    </div>
    <form action="admin_dashboard.php" method="POST">
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
