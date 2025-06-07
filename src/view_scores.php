<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/view_scores.css">
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
    <?php
    // 顯示刪除結果訊息
    if (isset($_POST['delete_success']) && $_POST['delete_success'] === '1') {
        echo '<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">隊伍及相關評分資料刪除成功！</div>';
    }
    if (isset($_POST['delete_error'])) {
        echo '<div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">刪除失敗：' . htmlspecialchars($_POST['delete_error']) . '</div>';
    }
    ?>

    <form action="view_scores.php" method="POST">
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
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </form>

    <!-- 編輯表單 (預設隱藏) -->
    <div id="editForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>編輯評分資料</h3>
            <form id="updateForm" method="POST" action="update_score.php">
                <input type="hidden" id="edit_team_id" name="team_id" value="">
                <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                
                <div class="form-group">
                    <label for="edit_team_name">隊伍名稱:</label>
                    <input type="text" id="edit_team_name" name="team_name" readonly>
                </div>
                
                <div class="form-group">
                    <label for="edit_rank">名次:</label>
                    <input type="number" id="edit_rank" name="rank" min="1" required>
                </div>
                
                <div class="form-group">
                    <label>評審評分:</label>
                    <div id="judge_scores_container">
                        <!-- 動態生成的評審評分欄位 -->
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-save">儲存</button>
                    <button type="button" class="btn-cancel" onclick="closeEditForm()">取消</button>
                </div>
            </form>
        </div>
    </div>

    <div class="rounded-box">
      <table style="width:100%">
          <tr>
              <th>隊伍</th>
              <th>評審:得分</th>
              <th>名次</th>
              <th>操作</th>
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
                              
                              // 查詢評分資料 - 使用隊伍編號
                              $scores_display = 'N/A';
                              $scores_data = [];
                              if ($team_id !== null) {
                                  try {
                                      $scoreResponse = $supabaseClient->get('評分資料', [
                                          'query' => [
                                              '隊伍編號' => 'eq.' . $team_id,
                                              'select' => '*',
                                          ]
                                      ]);
                                      
                                      if ($scoreResponse->getStatusCode() == 200) {
                                          $scoreData = json_decode($scoreResponse->getBody()->getContents(), true);
                                          if (!empty($scoreData)) {
                                              $score_details = [];
                                              foreach ($scoreData as $score) {
                                                  // 查詢評審姓名
                                                  $judgeResponse = $supabaseClient->get('評審委員', [
                                                      'query' => [
                                                          '身分證字號' => 'eq.' . $score['身分證字號'],
                                                          'select' => '姓名',
                                                      ]
                                                  ]);
                                                  
                                                  if ($judgeResponse->getStatusCode() == 200) {
                                                      $judgeData = json_decode($judgeResponse->getBody()->getContents(), true);
                                                      if (!empty($judgeData)) {
                                                          $judge_name = $judgeData[0]['姓名'];
                                                          $score_details[] = $judge_name . ': ' . $score['評分'];
                                                          $scores_data[] = [
                                                              'judge_name' => $judge_name,
                                                              'judge_id' => $score['身分證字號'],
                                                              'score' => $score['評分']
                                                          ];
                                                      }
                                                  }
                                              }
                                              $scores_display = implode('; ', $score_details);
                                          }
                                      }
                                  } catch (Exception $e) {
                                      // 查詢評分失敗，保持 N/A
                                  }
                              }
                              echo "<td>" . $scores_display . "</td>";
                              
                              // 名次
                              $rank = isset($row['名次']) ? htmlspecialchars($row['名次'], ENT_QUOTES, 'UTF-8') : 'N/A';
                              echo "<td>" . $rank . "</td>";
                              
                              // 操作按鈕
                              echo "<td>";
                              if ($team_id !== null) {
                                  $edit_data = json_encode([
                                      'team_id' => $team_id,
                                      'team_name' => $row['隊伍名稱'] ?? '',
                                      'rank' => $row['名次'] ?? '',
                                      'scores' => $scores_data
                                  ]);
                                  echo "<button class='btn-delete' onclick='confirmDelete(\"" . $team_id . "\", \"" . htmlspecialchars($team_name, ENT_QUOTES, 'UTF-8') . "\")' style='background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 12px;'>刪除</button>";
                              }
                              echo "</td>";
                              
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='4'>查無 " . htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8') . " 年度的隊伍資料。</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='4'>查詢隊伍資料失敗，HTTP 狀態碼：" . $status_code . "</td></tr>";
                  }
              } catch (GuzzleHttp\Exception\RequestException $e) {
                  echo "<tr><td colspan='4'>Guzzle 請求錯誤: ";
                  if ($e->hasResponse()) {
                      echo htmlspecialchars($e->getResponse()->getBody()->getContents(), ENT_QUOTES, 'UTF-8');
                  } else {
                      echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                  }
                  echo "</td></tr>";
              } catch (Exception $e) {
                  echo "<tr><td colspan='4'>執行查詢時發生例外狀況: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
              }
          }
          ?>
      </table>
    </div>
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit">返回</button>
    </form>
  </main>

  <script>
    function openEditForm(data) {
        // 填入表單資料
        document.getElementById('edit_team_id').value = data.team_id;
        document.getElementById('edit_team_name').value = data.team_name;
        document.getElementById('edit_rank').value = data.rank;
        
        // 動態生成評審評分欄位
        const container = document.getElementById('judge_scores_container');
        container.innerHTML = '';
        
        if (data.scores && data.scores.length > 0) {
            data.scores.forEach((score, index) => {
                const scoreDiv = document.createElement('div');
                scoreDiv.className = 'score-input-group';
                scoreDiv.innerHTML = `
                    <label>${score.judge_name}:</label>
                    <input type="hidden" name="judge_ids[]" value="${score.judge_id}">
                    <input type="number" name="scores[]" value="${score.score}" min="0" max="100" step="0.1" required>
                `;
                container.appendChild(scoreDiv);
            });
        }
        
        // 顯示編輯表單
        document.getElementById('editForm').style.display = 'flex';
    }

    function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }

    function confirmDelete(teamId, teamName) {
        if (confirm('確定要刪除隊伍「' + teamName + '」的所有評分資料嗎？\n此操作將同時刪除該隊伍的所有相關資料，且無法復原！')) {
            // 創建隱藏表單來提交刪除請求
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'delete_score.php';
            
            // 添加隊伍編號
            var teamIdInput = document.createElement('input');
            teamIdInput.type = 'hidden';
            teamIdInput.name = 'team_id';
            teamIdInput.value = teamId;
            form.appendChild(teamIdInput);
            
            // 添加用戶名和密碼（保持會話）
            var usernameInput = document.createElement('input');
            usernameInput.type = 'hidden';
            usernameInput.name = 'username';
            usernameInput.value = document.querySelector('input[name="username"]').value;
            form.appendChild(usernameInput);
            
            var passwordInput = document.createElement('input');
            passwordInput.type = 'hidden';
            passwordInput.name = 'password';
            passwordInput.value = document.querySelector('input[name="password"]').value;
            form.appendChild(passwordInput);
            
            // 添加年份
            var yearInput = document.createElement('input');
            yearInput.type = 'hidden';
            yearInput.name = 'year';
            yearInput.value = document.querySelector('select[name="year"]').value;
            form.appendChild(yearInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // 點擊背景關閉表單
    document.getElementById('editForm').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditForm();
        }
    });
  </script>
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
