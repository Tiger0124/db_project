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
    <h2>學生資料查詢</h2>
    <p>以下是所有學生的資料，您可以選擇編輯或刪除學生資料。</p>
    <div id="addForm" class="edit-form-container" style="display: none;">
        <div class="edit-form">
            <h3>新增學生</h3>
                <div class="form-group">
                    <label for="add_student_id">學號:</label>
                    <input type="text" id="add_student_id" name="student_id" required>
                </div>

                <div class="form-group">
                    <label for="add_student_name">姓名:</label>
                    <input type="text" id="add_student_name" name="student_name" required>
                </div>

                <div class="form-group">
                    <label for="add_id_number">身分證字號:</label>
                    <input type="text" id="add_id_number" name="id_number" required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>

                <div class="form-group">
                    <label for="department">科系:</label>
                    <input type="text" id="department" name="department" required>
                </div>

                <div class="form-group">
                    <label for="add_email">電子郵件:</label>
                    <input type="email" id="add_email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="add_phone">電話:</label>
                    <input type="tel" id="add_phone" name="phone" required>
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
                <th>姓名</th>
                <th>身分證字號</th>
                <th>科系</th>
                <th>電話</th>
                <th>電子郵件</th>
                <th>學號</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>王小明</td>
                <td>A123456789</td>
                <td>資訊工程學系</td>
                <td>0912345678</td>
                <td>mike@example.com</td>
                <td>A1111111</td>
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
            <h3>編輯學生資料</h3>
            <div class="form-group">
                    <label for="edit_student_id">學號:</label>
                    <input type="text" id="edit_student_id" disabled>
                </div>

                <div class="form-group">
                    <label for="edit_student_name">姓名:</label>
                    <input type="text" id="edit_student_name" required>
                </div>

                <div class="form-group">
                    <label for="edit_id_number">身分證字號:</label>
                    <input type="text" id="edit_id_number" required maxlength="10" pattern="[A-Z][0-9]{9}">
                </div>

                <div class="form-group">
                    <label for="edit_department">科系:</label>
                    <input type="text" id="edit_department" required>
                </div>

                <div class="form-group">
                    <label for="edit_email">電子郵件:</label>
                    <input type="email" id="edit_email" required>
                </div>

                <div class="form-group">
                    <label for="edit_phone">電話:</label>
                    <input type="tel" id="edit_phone" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-save" onclick="update()">儲存</button>
                    <button type="button" class="btn-cancel" onclick="closeEditForm()">取消</button>
                </div>
        </div>
    </div>
    <button id="insert_one" onclick="document.getElementById('addForm').style.display = 'flex'">新增學生</button>
    <button id="insert_many" onclick="document.getElementById('mutiaddForm').style.display = 'flex'">新增多位學生</button>
    <button id="delete_selected" onclick="delete_student()">刪除選擇的學生</button>
    <div class="rounded-box">
      <table id="student_table" style="width:100%">
          <tr>
            <th><input type="checkbox" id="select-all"></th>
            <th>學號</th>
            <th>姓名</th>
            <th>身分證字號</th>
            <th>科系</th>
            <th>電話</th>
            <th>電子郵件</th>
            <th>最近參與的隊伍編號</th>
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
            const { data: students, error } = await supabaseClient
                .from('學生')
                .select('*')

            if (error) {
                console.error('Error fetching students:', error);
                return;
            }
            

            const table = document.getElementById('student_table');
            students.forEach(student => {
                if(!student.隊伍編號) {
                student.隊伍編號 = 'N/A';
                }
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox" class="student-checkbox"></td>
                    <td>${student.學號}</td>
                    <td>${student.姓名}</td>
                    <td>${student.身分證字號}</td>
                    <td>${student.科系}</td>
                    <td>${student.電話}</td>
                    <td>${student.電子郵件}</td>
                    <td>${student.隊伍編號}</td>
                    <td><button class="edit-button">編輯</button></td>
                `;
                table.appendChild(row);
            });
        }
        retrival();
        // button to select all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('student_table').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('edit-button')) {
                const row = e.target.closest('tr');
                const studentId = row.children[1].textContent;
                const studentName = row.children[2].textContent;
                const idNumber = row.children[3].textContent;
                const department = row.children[4].textContent;
                const phone = row.children[5].textContent;
                const email = row.children[6].textContent;

                document.getElementById('edit_student_id').value = studentId;
                document.getElementById('edit_student_name').value = studentName;
                document.getElementById('edit_id_number').value = idNumber;
                document.getElementById('edit_department').value = department;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value = phone;

                document.getElementById('editForm').style.display = 'flex';
            }
        });

        function insert() {
            const studentId = document.getElementById('add_student_id').value;
            const studentName = document.getElementById('add_student_name').value;
            const idNumber = document.getElementById('add_id_number').value;
            const department = document.getElementById('department').value;
            const email = document.getElementById('add_email').value;
            const phone = document.getElementById('add_phone').value;

            if (!studentId || !studentName || !idNumber || !department || !email || !phone) {
                alert('請填寫所有欄位！');
                return;
            }

            supabaseClient
                .from('學生')
                .insert([
                    { 學號: studentId, 姓名: studentName, 身分證字號: idNumber, 科系: department, 電子郵件: email, 電話: phone }
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
                const students = rows.slice(1).map(row => ({
                    姓名: clean(row[0].trim()),
                    身分證字號: clean(row[1].trim()),
                    科系: clean(row[2].trim()),
                    電話: clean(row[3].trim()),
                    電子郵件: clean(row[4].trim()),
                    學號: clean(row[5].trim())
                }));

                for (const student of students) {
                    if (!student.學號 || !student.姓名 || !student.身分證字號 || !student.科系 || !student.電子郵件 || !student.電話) {
                        alert('CSV 檔案中有空白欄位，請檢查！');
                        return;
                    }
                }
                console.log('Students to insert:', students);
                const { data, error } = await supabaseClient
                    .from('學生')
                    .insert(students);
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
            const studentId = document.getElementById('edit_student_id').value;
            const studentName = document.getElementById('edit_student_name').value;
            const idNumber = document.getElementById('edit_id_number').value;
            const department = document.getElementById('edit_department').value;
            const email = document.getElementById('edit_email').value;
            const phone = document.getElementById('edit_phone').value;

            if (!studentId || !studentName || !idNumber || !department || !email || !phone) {
                alert('請填寫所有欄位！');
                return;
            }

            supabaseClient
                .from('學生')
                .update({ 姓名: studentName, 身分證字號: idNumber, 科系: department, 電子郵件: email, 電話: phone })
                .eq('學號', studentId)
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
                alert('請選擇至少一個學生！');
                return;
            }

            const studentIds = Array.from(checkboxes).map(checkbox => checkbox.closest('tr').children[1].textContent);

            supabaseClient
                .from('學生')
                .delete()
                .in('學號', studentIds)
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
            document.getElementById('add_student_id').value = '';
            document.getElementById('add_student_name').value = '';
            document.getElementById('add_id_number').value = '';
            document.getElementById('add_email').value = '';
            document.getElementById('add_phone').value = '';
            document.getElementById('department').value = '';
        }
        function closeEditForm() {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('edit_student_id').value = '';
            document.getElementById('edit_student_name').value = '';
            document.getElementById('edit_id_number').value = '';
            document.getElementById('edit_email').value = '';
            document.getElementById('edit_phone').value = '';
            document.getElementById('edit_department').value = '';
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