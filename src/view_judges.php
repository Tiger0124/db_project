<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="../asset/view_students.css">
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
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
    <h2>評審委員資料查詢</h2>
    <p>以下是所有評審委員的資料，您可以選擇編輯或刪除評審委員資料。</p>
    <!-- 欄位順序
        身分證字號
        姓名
        頭銜
        電話
        電子郵件
        密碼
        最近一次參與比賽 -->
    <div id="addForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>新增評審</h3>
                <div class="form-group">
                    <label for="add_judge_id">身分證字號:</label>
                    <input type="text" id="add_judge_id" required>
                </div>

                <div class="form-group">
                    <label for="add_judge_name">姓名:</label>
                    <input type="text" id="add_judge_name" required>
                </div>

                <div class="form-group">
                    <label for="add_subname">頭銜:</label>
                    <input type="text" id="add_subname" required>
                </div>

                <div class="form-group">
                    <label for="add_judge_number">電話:</label>
                    <input type="tel" id="add_judge_number"  required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>

                <div class="form-group">
                    <label for="add_email">電子郵件:</label>
                    <input type="email" id="add_email" required>
                </div>
                <div class="form-group">
                    <label for="add_pwd">密碼:</label>
                    <input type="text" id="add_pwd" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-save" onclick="insert()">新增</button>
                    <button type="button" class="btn-cancel" onclick="closeAddForm()">取消</button>
                </div>
        </div>
    </div>
    <div id="mutiaddForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>上傳csv檔</h3>
            <p>請依以下欄位順序準備 CSV 檔案，欄位需為 UTF-8 編碼：</p>
            <table id = "example" style="width:100%; text-align:center;">
            <thead>
                <tr>
                <th>身分證字號</th>
                <th>姓名</th>
                <th>頭銜</th>
                <th>電話</th>
                <th>電子郵件</th>
                <th>密碼</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>A123456789</td>
                <td>王小明</td>
                <td>教授</td>
                <td>0912345678</td>
                <td>mike@example.com</td>
                <td>password</td>
                </tr>
            </tbody>
            </table>
            <div id="csvUploadForm" class="form-group" style="margin-top: 1rem;">
                <label for="csv_file">選擇 CSV 檔案：</label>
                <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-save" onclick="muti_insert()">上傳</button>
                <button type="button" class="btn-cancel" onclick="closeMutiAddForm()">取消</button>
            </div>
        </div>
    </div>
    <div id="editForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>編輯評審資料</h3>
            <div class="form-group">
                    <label for="edit_judge_id">身分證字號:</label>
                    <input type="text" id="edit_judge_id" disabled>
                </div>

                <div class="form-group">
                    <label for="edit_judge_name">姓名:</label>
                    <input type="text" id="edit_judge_name" required>
                </div>

                <div class="form-group">
                    <label for="edit_subname">頭銜:</label>
                    <input type="text" id="edit_subname" required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>
                <div class="form-group">
                    <label for="edit_number">電話:</label>
                    <input type="tel" id="edit_number" required>
                </div>

                <div class="form-group">
                    <label for="edit_email">電子郵件:</label>
                    <input type="email" id="edit_email" required>
                </div>

                <div class="form-group">
                    <label for="edit_pwd">密碼:</label>
                    <input type="tel" id="edit_pwd" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-save" onclick="update()">儲存</button>
                    <button type="button" class="btn-cancel" onclick="closeEditForm()">取消</button>
                </div>
        </div>
    </div>
    <button id="insert_one" onclick="document.getElementById('addForm').style.display = 'flex'">新增評審</button>
    <button id="insert_many" onclick="document.getElementById('mutiaddForm').style.display = 'flex'">新增多位評審</button>
    <button id="delete_selected" onclick="delete_student()">刪除選擇的評審</button>
    <div class="rounded-box">
      <table id="judge_table" style="width:100%">
          <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>身分證字號</th>
            <th>姓名</th>
            <th>頭銜</th>
            <th>電話</th>
            <th>電子郵件</th>
            <th>密碼</th>
            <th>最近一次參與的比賽</th>
            <th>編輯</th>
          </tr>
      </table>
    </div>
    

    <script>
        const { createClient } = supabase;
        const supabaseClient = createClient(
            'https://xlomzrhmzjjfjmsvqxdo.supabase.co',
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhsb216cmhtempqZmptc3ZxeGRvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDg0OTk3NTcsImV4cCI6MjA2NDA3NTc1N30.AaGloZjC_aqW3OQkn4aDxy7SGymfTsJ6JWNWJYcYbGo'
        );
        async function retrival() {
            const { data: judges, error } = await supabaseClient
                .from('評審委員')
                .select('*')

            if (error) {
                console.error('Error fetching judges:', error);
                return;
            }
            const yearMap = {
                1: 2013,
                2: 2014,
                3: 2015,
                4: 2016,
                5: 2017,
                6: 2018,
                7: 2019,
                8: 2020,
                9: 2021,
                10: 2022,
                11: 2023,
                12: 2024,
                13: 2025
            };

            const table = document.getElementById('judge_table');
            judges.forEach(judge => {
                if(!judge.屆數) {
                judge.屆數 = 'N/A';
                }
                judge.屆數 = yearMap[judge.屆數];
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox" class="judge-checkbox"></td>
                    <td>${judge.身分證字號}</td>
                    <td>${judge.姓名}</td>
                    <td>${judge.頭銜}</td>
                    <td>${judge.電話}</td>
                    <td>${judge.電子郵件}</td>
                    <td>${judge.密碼}</td>
                    <td>${judge.屆數}</td>
                    <td><button class="edit-button">編輯</button></td>
                `;
                table.appendChild(row);
            });
        }
        retrival();
        // button to select all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.judge-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('judge_table').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-button')) {
                const row = e.target.closest('tr');

                document.getElementById('edit_judge_id').value = row.children[1].textContent;
                document.getElementById('edit_judge_name').value = row.children[2].textContent;
                document.getElementById('edit_subname').value = row.children[3].textContent;
                document.getElementById('edit_number').value = row.children[4].textContent;
                document.getElementById('edit_email').value = row.children[5].textContent;
                document.getElementById('edit_pwd').value = row.children[6].textContent;

                document.getElementById('editForm').style.display = 'flex';
            }
        });

        function insert() {
            const judgeId = document.getElementById('add_judge_id').value;
            const judgeName = document.getElementById('add_judge_name').value;
            const password = document.getElementById('add_pwd').value;
            const subname = document.getElementById('add_subname').value;
            const email = document.getElementById('add_email').value;
            const phone = document.getElementById('add_judge_number').value;


            if (!judgeId || !judgeName || !password || !subname || !email || !phone) {
                alert('請填寫所有欄位！');
                return;
            }

            supabaseClient
                .from('評審委員')
                .insert([
                    { 
                        身分證字號: judgeId, 
                        屆數: '13',
                        姓名: judgeName,
                        頭銜: subname,  
                        電話: phone, 
                        電子郵件: email, 
                        密碼: password 
                    }
                ])
                .then(response => {
                    if (response.error) {
                        alert('新增失敗：' + response.error.message);
                    } else {
                        alert('新增成功！');
                        closeAddForm();
                        location.reload();
                    }
                });
        }

        function muti_insert() {
            const fileInput = document.getElementById('csv_file');
            if (!fileInput.files.length) {
                alert('請選擇一個 CSV 檔案！');
                return;
            }
            const clean = val => val?.trim().replace(/^"+|"+$/g, '');
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = async function(event) {
                const csvData = event.target.result;
                const rows = csvData.split('\n').map(row => row.split(','));
                const judges = rows.slice(1).map(row => ({
                    身分證字號: clean(row[0].trim()),
                    屆數: '13',
                    姓名: clean(row[1].trim()),
                    頭銜: clean(row[2].trim()),
                    電話: clean(row[3].trim()),
                    電子郵件: clean(row[4].trim()),
                    密碼: clean(row[5].trim())
                }));

                for (const judge of judges) {
                    if (!judge.姓名 || !judge.電話 || !judge.電子郵件 || !judge.身分證字號 || !judge.頭銜 || !judge.密碼) {
                        alert('CSV 檔案中有空白欄位，請檢查！');
                        return;
                    }
                }
                console.log('judges to insert:', judges);
                const { data, error } = await supabaseClient
                    .from('評審委員')
                    .insert(judges);
                if (error) {
                    alert('上傳失敗：' + error.message);
                } else {
                    alert('上傳成功！');
                    closeMutiAddForm();
                    location.reload();
                }
            };
            reader.readAsText(file);
        }

        function update() {
            const judgeId = document.getElementById('edit_judge_id').value;
            const judgeName = document.getElementById('edit_judge_name').value;
            const password = document.getElementById('edit_pwd').value;
            const subname = document.getElementById('edit_subname').value;
            const email = document.getElementById('edit_email').value;
            const phone = document.getElementById('edit_number').value;
            if (!judgeId || !judgeName || !password || !subname || !email || !phone) {
                alert('請填寫所有欄位！');
                return;
            }
            supabaseClient
                .from('評審委員')
                .update({ 姓名: judgeName, 電話: phone, 電子郵件: email, 頭銜: subname, 密碼: password })
                .eq('身分證字號', judgeId)
                .then(response => {
                    if (response.error) {
                        alert('更新失敗：' + response.error.message);
                    } else {
                        alert('更新成功！');
                        closeEditForm();
                        location.reload();
                    }
                });
        }

        function delete_student() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                alert('請選擇至少一個評審！');
                return;
            }

            const judgesIds = Array.from(checkboxes).map(checkbox => checkbox.closest('tr').children[1].textContent);

            supabaseClient
                .from('評審委員')
                .delete()
                .in('身分證字號', judgesIds)
                .then(response => {
                    if (response.error) {
                        alert('刪除失敗：' + response.error.message);
                    } else {
                        alert('刪除成功！');
                        location.reload();
                    }
                });
        }

        function closeMutiAddForm() {
            document.getElementById('mutiaddForm').style.display = 'none';
            document.getElementById('csv_file').value = '';
        }
        function closeAddForm() {
            document.getElementById('addForm').style.display = 'none';
            document.getElementById('add_judge_id').value = '';
            document.getElementById('add_judge_name').value = '';
            document.getElementById('add_subname').value = '';
            document.getElementById('add_judge_number').value = '';
            document.getElementById('add_email').value = '';
            document.getElementById('add_pwd').value = '';
        }
        function closeEditForm() {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('edit_judge_id').value = '';
            document.getElementById('edit_judge_name').value = '';
            document.getElementById('edit_subname').value = '';
            document.getElementById('edit_number').value = '';
            document.getElementById('edit_email').value = '';
            document.getElementById('edit_pwd').value = '';
        }


        
    </script>
    
    <form action="admin_dashboard.php" method="POST">
        <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <input type="hidden" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : ''; ?>">
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
