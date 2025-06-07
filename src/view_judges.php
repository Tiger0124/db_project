<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>高雄大學創意競賽管理系統</title>
  <link rel="stylesheet" href="../asset/view_judges.css">
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
        echo '<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">評審委員刪除成功！</div>';
    }
    if (isset($_POST['delete_error'])) {
        echo '<div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;">刪除失敗：' . htmlspecialchars($_POST['delete_error']) . '</div>';
    }
    ?>
    <form action="view_judges.php" method="POST">
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
        <button type="button" class="btn-add" onclick="openAddForm()">新增評審</button>
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </form>

    <!-- 新增評審表單 (預設隱藏) -->
    <div id="addForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>新增評審委員</h3>
            <form id="addJudgeForm" method="POST" action="add_judge.php">
                <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                
                <div class="form-group">
                    <label for="add_id_number">身分證字號:</label>
                    <input type="text" id="add_id_number" name="id_number" required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>
                
                <div class="form-group">
                    <label for="add_email">電子郵件:</label>
                    <input type="email" id="add_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="add_title">頭銜:</label>
                    <input type="text" id="add_title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="add_name">姓名:</label>
                    <input type="text" id="add_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="add_phone">電話:</label>
                    <input type="tel" id="add_phone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="add_phone">密碼:</label>
                    <input type="password" id="add_password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="add_session">屆數:</label>
                    <select id="add_session" name="session" required>
                        <option value="">請選擇屆數</option>
                        <option value="第1屆">第1屆</option>
                        <option value="第2屆">第2屆</option>
                        <option value="第3屆">第3屆</option>
                        <option value="第4屆">第4屆</option>
                        <option value="第5屆">第5屆</option>
                        <option value="第6屆">第6屆</option>
                        <option value="第7屆">第7屆</option>
                        <option value="第8屆">第8屆</option>
                        <option value="第9屆">第9屆</option>
                        <option value="第10屆">第10屆</option>
                        <option value="第11屆">第11屆</option>
                        <option value="第12屆">第12屆</option>
                        <option value="第13屆">第13屆</option>
                    </select>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-save">新增</button>
                    <button type="button" class="btn-cancel" onclick="closeAddForm()">取消</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 編輯評審表單 (預設隱藏) -->
    <div id="editForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>編輯評審委員</h3>
            <form id="updateForm" method="POST" action="update_judges.php">
                <input type="hidden" id="edit_original_id" name="original_id" value="">
                <input type="hidden" id="edit_original_session" name="original_session" value="">
                <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <input type="hidden" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                
                <div class="form-group">
                    <label for="edit_id_number">身分證字號:</label>
                    <input type="text" id="edit_id_number" name="id_number" required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>
                
                <div class="form-group">
                    <label for="edit_email">電子郵件:</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_title">頭銜:</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_name">姓名:</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_phone">電話:</label>
                    <input type="tel" id="edit_phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="edit_phone">密碼:</label>
                    <input type="password" id="edit_password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="edit_session">屆數:</label>
                    <select id="edit_session" name="session" required>
                        <option value="">請選擇屆數</option>
                        <option value="第1屆">第1屆</option>
                        <option value="第2屆">第2屆</option>
                        <option value="第3屆">第3屆</option>
                        <option value="第4屆">第4屆</option>
                        <option value="第5屆">第5屆</option>
                        <option value="第6屆">第6屆</option>
                        <option value="第7屆">第7屆</option>
                        <option value="第8屆">第8屆</option>
                        <option value="第9屆">第9屆</option>
                        <option value="第10屆">第10屆</option>
                        <option value="第11屆">第11屆</option>
                        <option value="第12屆">第12屆</option>
                        <option value="第13屆">第13屆</option>
                    </select>
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
                <th>身分證字號</th>
                <th>電子郵件</th>
                <th>頭銜</th>
                <th>姓名</th>
                <th>電話</th>
                <th>密碼</th>
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
                $session = $yearToSession[$selectedYear];
                $sessionNumber = str_replace(['第', '屆'], '', $session);//13
                try {
                    // 使用屆數進行查詢
                    $response = $supabaseClient->get('評審委員', [
                        'query' => [
                            '屆數' => 'eq.' . $sessionNumber,
                            'select' => '*',
                        ]
                    ]);

                    $status_code = $response->getStatusCode();
                    
                    if ($status_code == 200) {
                        $judgesData = json_decode($response->getBody()->getContents(), true);

                        if (!empty($judgesData)) {
                            foreach ($judgesData as $row) {
                                echo "<tr>";
                                
                                // 身分證字號
                                $id_number = isset($row['身分證字號']) ? htmlspecialchars($row['身分證字號'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $id_number . "</td>";
                                
                                // 電子郵件
                                $email = isset($row['電子郵件']) ? htmlspecialchars($row['電子郵件'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $email . "</td>";
                                
                                // 頭銜
                                $title = isset($row['頭銜']) ? htmlspecialchars($row['頭銜'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $title . "</td>";
                                
                                // 姓名
                                $name = isset($row['姓名']) ? htmlspecialchars($row['姓名'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $name . "</td>";
                                
                                // 電話
                                $phone = isset($row['電話']) ? htmlspecialchars($row['電話'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $phone . "</td>";

                                // 電話
                                $password = isset($row['密碼']) ? htmlspecialchars($row['密碼'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                echo "<td>" . $password . "</td>";

                                // 操作按鈕
                                echo "<td>";
                                $edit_data = json_encode([
                                    'id_number' => $row['身分證字號'] ?? '',
                                    'email' => $row['電子郵件'] ?? '',
                                    'title' => $row['頭銜'] ?? '',
                                    'name' => $row['姓名'] ?? '',
                                    'phone' => $row['電話'] ?? '',
                                    'session' => $row['屆數'] ?? '',
                                    'password' => $row['密碼'] ?? ''
                                ]);
                                echo "<button class='btn-edit' onclick='openEditForm(" . htmlspecialchars($edit_data, ENT_QUOTES, 'UTF-8') . ")'>編輯</button>";
                                // 新增刪除按鈕
                                echo "<button class='btn-delete' onclick='confirmDelete(\"" . htmlspecialchars($row['身分證字號'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['姓名'], ENT_QUOTES, 'UTF-8') . "\", \"" . htmlspecialchars($row['屆數'], ENT_QUOTES, 'UTF-8') . "\")' style='background-color: #dc3545; margin-left: 5px; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 12px;'>刪除</button>";
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>查無 " . htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8') . " 年度（" . htmlspecialchars($session, ENT_QUOTES, 'UTF-8') . "）的評審委員資料。</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>查詢評審委員資料失敗，HTTP 狀態碼：" . $status_code . "</td></tr>";
                    }
                } catch (GuzzleHttp\Exception\RequestException $e) {
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
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button type="submit">返回</button>
    </form>
  </main>

  <script>
    function openAddForm() {
        // 如果有選擇年份，自動設定對應的屆數
        const yearSelect = document.querySelector('select[name="year"]');
        const sessionSelect = document.getElementById('add_session');
        
        if (yearSelect.value) {
            const yearToSession = {
                2013: "第1屆", 2014: "第2屆", 2015: "第3屆", 2016: "第4屆",
                2017: "第5屆", 2018: "第6屆", 2019: "第7屆", 2020: "第8屆",
                2021: "第9屆", 2022: "第10屆", 2023: "第11屆", 2024: "第12屆",
                2025: "第13屆"
            };
            sessionSelect.value = yearToSession[yearSelect.value] || "";
        }
        
        // 顯示新增表單
        document.getElementById('addForm').style.display = 'flex';
    }

    function closeAddForm() {
        document.getElementById('addForm').style.display = 'none';
        // 清空表單
        document.getElementById('addJudgeForm').reset();
    }

    function openEditForm(data) {
        // 填入表單資料
        document.getElementById('edit_original_id').value = data.id_number;
        document.getElementById('edit_original_session').value = data.session;
        document.getElementById('edit_id_number').value = data.id_number;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_title').value = data.title;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_phone').value = data.phone;
        document.getElementById('edit_password').value = data.password;
        document.getElementById('edit_session').value = data.session;
        
        // 顯示編輯表單
        document.getElementById('editForm').style.display = 'flex';
    }

    function closeEditForm() {
        document.getElementById('editForm').style.display = 'none';
    }

    // 在現有的 JavaScript 函數後面新增
    function confirmDelete(idNumber, judgeName, session) {
        if (confirm('確定要刪除評審委員「' + judgeName + '」嗎？\n身分證字號：' + idNumber + '\n屆數：第' + session + '屆\n此操作無法復原！')) {
            // 創建隱藏表單來提交刪除請求
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'delete_judge.php';
            
            // 添加身分證字號
            var idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id_number';
            idInput.value = idNumber;
            form.appendChild(idInput);
            
            // 添加屆數
            var sessionInput = document.createElement('input');
            sessionInput.type = 'hidden';
            sessionInput.name = 'session';
            sessionInput.value = session;
            form.appendChild(sessionInput);
            
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
