<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統 - 教師檢視</title>
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

    <?php
    // 顯示刪除結果訊息
    if (isset($_POST['delete_success']) && $_POST['delete_success'] === '1') {
        echo '<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">隊伍刪除成功！</div>';
    }
    if (isset($_POST['delete_error'])) {
        echo '<div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">刪除失敗：' . htmlspecialchars($_POST['delete_error']) . '</div>';
    }
    ?>

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
        <button type="button" class="btn-add" onclick="openAddForm()">新增教師</button>
        <?php
        $username_from_post = isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : '';
        $password_from_post = isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : '';
        ?>
        <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
        <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
    </form>

    <!-- 新增教師表單 (預設隱藏) -->
    <div id="addForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>新增指導老師</h3>
            <form id="addTeacherForm" method="POST" action="add_teacher.php">
                <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
                <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
                <input type="hidden" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                
                <div class="form-group">
                    <label for="add_id_number">身分證字號:</label>
                    <input type="text" id="add_id_number" name="id_number" required maxlength="10" pattern="[A-Z][0-9]{9}" placeholder="例：A123456789">
                </div>
                
                <div class="form-group">
                    <label for="add_teacher_name">姓名:</label>
                    <input type="text" id="add_teacher_name" name="teacher_name" required>
                </div>
                
                <div class="form-group">
                    <label for="add_phone">電話:</label>
                    <input type="tel" id="add_phone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="add_email">電子郵件:</label>
                    <input type="email" id="add_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="add_title">職稱:</label>
                    <input type="text" id="add_title" name="title" required placeholder="例：教授、副教授、助理教授">
                </div>
                
                <div class="form-group">
                    <label for="add_teacher_password">密碼:</label>
                    <input type="password" id="add_teacher_password" name="teacher_password" required minlength="6" placeholder="請輸入至少6位密碼">
                </div>
                
                <div class="form-group">
                    <label for="add_participate_year">參加年份:</label>
                    <select id="add_participate_year" name="participate_year" required>
                        <option value="">請選擇參加年份</option>
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
                </div>
                
                <div class="form-group">
                    <label for="add_team_id">隊伍編號:</label>
                    <input type="text" id="add_team_id" name="team_id" required placeholder="請輸入隊伍編號">
                    <small class="form-text">請確認隊伍編號是否存在</small>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-save">新增</button>
                    <button type="button" class="btn-cancel" onclick="closeAddForm()">取消</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 編輯教師表單 (預設隱藏) -->
    <div id="editForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>編輯教師資料</h3>
            <form id="updateForm" method="POST" action="update_teachers.php">
                <input type="hidden" id="edit_team_id" name="team_id" value="">
                <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
                <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
                <input type="hidden" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                
                <div class="form-group">
                    <label for="edit_teacher_name">指導老師姓名:</label>
                    <input type="text" id="edit_teacher_name" name="teacher_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_teacher_title">職稱:</label>
                    <input type="text" id="edit_teacher_title" name="teacher_title" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_team_name">隊伍名稱:</label>
                    <input type="text" id="edit_team_name" name="team_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_students">學生名單:</label>
                    <textarea id="edit_students" name="students" rows="3" placeholder="請用逗號分隔多個學生姓名"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_project_name">作品名稱:</label>
                    <input type="text" id="edit_project_name" name="project_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_project_description">作品描述:</label>
                    <textarea id="edit_project_description" name="project_description" rows="4"></textarea>
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
              <th>指導老師姓名</th>
              <th>職稱</th>
              <th>隊伍名稱</th>
              <th>學生名單</th>
              <th>作品名稱</th>
              <th>作品描述</th>
              <th>操作</th>
          </tr>
          <?php

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
                              
                              // 取得隊伍編號和隊伍名稱
                              $team_id = isset($row['隊伍編號']) ? $row['隊伍編號'] : null;
                              $team_name = isset($row['隊伍名稱']) ? htmlspecialchars($row['隊伍名稱'], ENT_QUOTES, 'UTF-8') : 'N/A';
                              
                              // 查詢指導老師 - 使用隊伍編號
                              $teacher_name = 'N/A';
                              $teacher_title = 'N/A';
                              if ($team_id !== null) {
                                  try {
                                      $teacherResponse = $supabaseClient->get('指導老師', [
                                          'query' => [
                                              '隊伍編號' => 'eq.' . $team_id,
                                              'select' => '姓名,職稱',
                                          ]
                                      ]);
                                      
                                      if ($teacherResponse->getStatusCode() == 200) {
                                          $teacherData = json_decode($teacherResponse->getBody()->getContents(), true);
                                          if (!empty($teacherData)) {
                                              $teacher_name = htmlspecialchars($teacherData[0]['姓名'], ENT_QUOTES, 'UTF-8');
                                              $teacher_title = htmlspecialchars($teacherData[0]['職稱'], ENT_QUOTES, 'UTF-8');
                                          }
                                      }
                                  } catch (Exception $e) {
                                      // 查詢指導老師失敗，保持 N/A
                                  }
                              }
                              echo "<td>" . $teacher_name . "</td>";
                              echo "<td>" . $teacher_title . "</td>";
                              
                              // 隊伍名稱
                              echo "<td>" . $team_name . "</td>";
                              
                              // 查詢學生資料 - 使用隊伍編號
                              $students_display = 'N/A';
                              $students_array = [];
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
                                                  $students_array[] = $student['姓名'];
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
                              
                              // 操作按鈕
                              echo "<td>";
                              if ($team_id !== null) {
                                  $edit_data = json_encode([
                                      'team_id' => $team_id,
                                      'teacher_name' => $teacher_name === 'N/A' ? '' : str_replace('&quot;', '"', html_entity_decode($teacher_name)),
                                      'teacher_title' => $teacher_title === 'N/A' ? '' : str_replace('&quot;', '"', html_entity_decode($teacher_title)),
                                      'team_name' => $row['隊伍名稱'] ?? '',
                                      'students' => implode(', ', $students_array),
                                      'project_name' => $project_name === 'N/A' ? '' : str_replace('&quot;', '"', html_entity_decode($project_name)),
                                      'project_description' => $project_description === 'N/A' ? '' : str_replace('&quot;', '"', html_entity_decode($project_description))
                                  ]);
                                  echo "<button class='btn-edit' onclick='openEditForm(" . htmlspecialchars($edit_data, ENT_QUOTES, 'UTF-8') . ")'>編輯</button>";
                                  echo "<button class='btn-delete' onclick='confirmDelete(\"" . $team_id . "\", \"" . htmlspecialchars($team_name, ENT_QUOTES, 'UTF-8') . "\")' style='background-color: #dc3545; margin-left: 5px; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 12px;'>刪除</button>";
                              }
                              echo "</td>";
                              
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='7'>查無 " . htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8') . " 年度的隊伍資料。</td></tr>";
                      }
                  } else {
                      echo "<tr><td colspan='7'>查詢隊伍資料失敗，HTTP 狀態碼：" . $status_code . "</td></tr>";
                  }
              } catch (GuzzleHttp\Exception\RequestException $e) {
                  echo "<tr><td colspan='7'>Guzzle 請求錯誤: ";
                  if ($e->hasResponse()) {
                      echo htmlspecialchars($e->getResponse()->getBody()->getContents(), ENT_QUOTES, 'UTF-8');
                  } else {
                      echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                  }
                  echo "</td></tr>";
              } catch (Exception $e) {
                  echo "<tr><td colspan='7'>執行查詢時發生例外狀況: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
              }
          }
          ?>
      </table>
    </div>
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $username_from_post; ?>">
        <input type="hidden" name="password" value="<?php echo $password_from_post; ?>">
        <button type="submit">返回</button>
    </form>
  </main>

  <script>
    function openAddForm() {
        // 如果有選擇年份，自動設定對應的參加年份
        const yearSelect = document.querySelector('select[name="year"]');
        const participateYearSelect = document.getElementById('add_participate_year');
        
        if (yearSelect.value) {
            participateYearSelect.value = yearSelect.value;
        }
        
        // 顯示新增表單
        document.getElementById('addForm').style.display = 'flex';
    }

    function closeAddForm() {
        document.getElementById('addForm').style.display = 'none';
        // 清空表單
        document.getElementById('addTeacherForm').reset();
    }

    function openEditForm(data) {
        // 填入表單資料
        document.getElementById('edit_team_id').value = data.team_id;
        document.getElementById('edit_teacher_name').value = data.teacher_name;
        document.getElementById('edit_teacher_title').value = data.teacher_title;
        document.getElementById('edit_team_name').value = data.team_name;
        document.getElementById('edit_students').value = data.students;
        document.getElementById('edit_project_name').value = data.project_name;
        document.getElementById('edit_project_description').value = data.project_description;
        
        // 顯示編輯表單
        document.getElementById('editForm').style.display = 'flex';
    }

    function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }

    // 在現有的 JavaScript 函數後面新增__刪除
    function confirmDelete(teamId, teamName) {
        if (confirm('確定要刪除隊伍「' + teamName + '」嗎？\n此操作將同時刪除相關的指導老師、學生和作品資料，且無法復原！')) {
            // 創建隱藏表單來提交刪除請求
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'delete_team_from_teachers.php';
            
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
    document.getElementById('addForm').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddForm();
        }
    });

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
