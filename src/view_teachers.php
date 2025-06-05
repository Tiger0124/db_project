<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統 - 教師檢視</title>
  <link rel="stylesheet" href="../asset/view_students.css"> <!-- 您可以為教師頁面建立新的 CSS 或重用 view_students.css -->
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
    <form action="view_teachers.php" method="POST">
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
        <?php
        // 保留 POST 過來的 username 和 password，以便返回時能傳遞
        // 使用 htmlspecialchars 避免 XSS
        $username_from_post = isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : '';
        $password_from_post = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : '';
        ?>
        <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
        <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
    </form>
    <div class="rounded-box">
      <table style="width:100%">
          <tr>
              <th>指導老師姓名</th>
              <th>職稱</th>
              <th>隊伍名稱</th>
              <th>學生名單</th>
              <th>作品名稱</th>
              <th>作品描述</th>
          </tr>
          <?php
          // 包含 Composer 的 autoloader
          require_once 'conn.php';
          $yearToSession = [
                2013 => "第1屆", 2014 => "第2屆", 2015 => "第3屆", 2016 => "第4屆",
                2017 => "第5屆", 2018 => "第6屆", 2019 => "第7屆", 2020 => "第8屆",
                2021 => "第9屆", 2022 => "第10屆", 2023 => "第11屆", 2024 => "第12屆",
                2025 => "第13屆"
            ];
              if (isset($_POST['year'])&& array_key_exists($_POST['year'], $yearToSession)) {
                // 年份到屆數的對應陣列，主要用於下拉選單顯示
                $selected_year = $_POST['year'];

                // Supabase 查詢參數
                // 1. 主查詢資料表為 '隊伍'
                // 2. select:
                //    - '隊伍名稱' (直接來自 隊伍 表)
                //    - '指導老師!inner(姓名,職稱)' : 嵌入關聯的 指導老師 資料，並選取其 姓名 和 職稱。
                //      '!inner' 表示如果隊伍沒有對應的指導老師則不返回該隊伍。
                //      如果指導老師是可選的，則用 '指導老師(姓名,職稱)'。
                //      假設 指導老師 表與 隊伍 表有關聯。
                //    - '學生(姓名)' : 嵌入關聯的 學生 資料，並選取其 姓名。
                //    - '作品!inner(作品名稱,作品描述)' : 嵌入關聯的 作品 資料。
                // 3. 篩選條件: '參加年份=eq.' . $selected_year
                // 4. 排序 (可選): 'order=指導老師.姓名.asc,隊伍名稱.asc' (按老師姓名，再按隊伍名稱)
                //    注意：排序關聯表欄位時，欄位名前面需要加上關聯表的名稱。

                $guzzle_query_params = [
                    'select' => '隊伍名稱,指導老師!inner(姓名,職稱),學生(姓名),作品!inner(作品名稱,作品描述)',
                    '參加年份' => 'eq.' . $selected_year,
                    // 'order' => '指導老師.姓名.asc,隊伍名稱.asc' // 如果需要排序，取消此行註解並確保欄位名正確
                ];

                try {
                    // 假設主查詢的資料表是 '隊伍'
                    $response = $supabaseClient->request('GET', '隊伍', [
                        'query' => $guzzle_query_params
                    ]);

                    $status_code = $response->getStatusCode();
                    $response_body_content = $response->getBody()->getContents();
                    $results = json_decode($response_body_content, true);

                    if ($status_code === 200 && is_array($results)) {
                        if (empty($results)) {
                            echo "<tr><td colspan='6'>查無 " . htmlspecialchars($selected_year, ENT_QUOTES, 'UTF-8') . " 年度的資料。</td></tr>";
                        } else {
                            foreach ($results as $row) {
                                echo "<tr>";

                                // 指導老師資訊
                                // Supabase 對於一對一或 !inner 的關聯，如果只符合一筆，通常會直接給物件
                                // 如果是標準的一對多，即使 !inner 且只符合一筆，也可能仍是含單一物件的陣列
                                // 這裡假設 '指導老師' 關聯返回的是單一物件或只取第一個
                                $teacher_name = 'N/A';
                                $teacher_title = 'N/A';
                                if (!empty($row['指導老師'])) {
                                    // 處理可能為物件或單元素陣列的情況
                                    $teacher_data = is_array($row['指導老師']) ? ($row['指導老師'][0] ?? null) : $row['指導老師'];
                                    if ($teacher_data) {
                                        $teacher_name = isset($teacher_data['姓名']) ? htmlspecialchars($teacher_data['姓名'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                        $teacher_title = isset($teacher_data['職稱']) ? htmlspecialchars($teacher_data['職稱'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                    }
                                }
                                echo "<td>" . $teacher_name . "</td>";
                                echo "<td>" . $teacher_title . "</td>";

                                // 隊伍名稱
                                $team_name = isset($row['隊伍名稱']) ? htmlspecialchars($row['隊伍名稱'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $team_name . "</td>";

                                // 學生名單 (類似 GROUP_CONCAT)
                                $student_names_list = [];
                                if (!empty($row['學生']) && is_array($row['學生'])) {
                                    foreach ($row['學生'] as $student) {
                                        if (isset($student['姓名'])) {
                                            $student_names_list[] = htmlspecialchars($student['姓名'], ENT_QUOTES, 'UTF-8');
                                        }
                                    }
                                }
                                $students_display = !empty($student_names_list) ? implode(', ', $student_names_list) : 'N/A';
                                echo "<td>" . $students_display . "</td>";

                                // 作品資訊 (與指導老師類似的處理邏輯)
                                $project_name = 'N/A';
                                $project_description = 'N/A';
                                if (!empty($row['作品'])) {
                                     $project_data = is_array($row['作品']) ? ($row['作品'][0] ?? null) : $row['作品'];
                                     if ($project_data) {
                                        $project_name = isset($project_data['作品名稱']) ? htmlspecialchars($project_data['作品名稱'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                        $project_description = isset($project_data['作品描述']) ? htmlspecialchars($project_data['作品描述'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                     }
                                }
                                echo "<td>" . $project_name . "</td>";
                                echo "<td>" . $project_description . "</td>";

                                echo "</tr>";
                            }
                        }
                    } else {
                        $error_message = '查詢時發生錯誤。';
                        if (is_array($results) && isset($results['message'])) {
                            $error_message .= ' Supabase 錯誤: ' . htmlspecialchars($results['message'], ENT_QUOTES, 'UTF-8');
                        } else if ($response_body_content) {
                             $error_message .= ' 伺服器回應 (部分): ' . htmlspecialchars(substr($response_body_content, 0, 200), ENT_QUOTES, 'UTF-8');
                        }
                        echo "<tr><td colspan='6'>" . $error_message . " (HTTP 狀態碼: " . $status_code . ")</td></tr>";
                    }

                } catch (RequestException $e) {
                    echo "<tr><td colspan='6'>Guzzle 請求錯誤: ";
                    if ($e->hasResponse()) {
                        echo htmlspecialchars($e->getResponse()->getBody()->getContents(), ENT_QUOTES, 'UTF-8');
                    } else {
                        echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                    }
                    echo "</td></tr>";
                } catch (Exception $e) {
                    echo "<tr><td colspan='6'>執行查詢時發生例外狀況: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
                }
              }
          ?>
      </table>
    </div>
    <form action="admin_dashboard.php" method="POST"> <!-- 返回按鈕通常指向儀表板或上一頁 -->
        <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
        <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
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