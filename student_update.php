<?php
include 'conn.php';
$select_db = @mysqli_select_db($link, "db_project");

// 從 POST 請求中接收資料
$team_id = $_POST['team_id']; // 假設隊伍編號已從表單傳入
$students = [];
$professor = []; // 指導老師資料
$currentYear = date("Y");

// 收集學生資料
foreach ($_POST as $key => $value) {
    if (strpos($key, 'student') !== false) {
        preg_match('/student(\d+)_(.+)/', $key, $matches);
        if (!empty($matches)) {
            $index = $matches[1];
            $field = $matches[2];
            $students[$index][$field] = $value;
        }
    }
}

// 收集指導老師資料
$professor['id'] = $_POST['professor_id'] ?? null;
$professor['name'] = $_POST['professor_name'] ?? null;
$professor['email'] = $_POST['professor_email'] ?? null;
$professor['phone'] = $_POST['professor_phone'] ?? null;

try {
    // 開啟交易
    mysqli_begin_transaction($link);

    // 先檢查隊伍編號和參加年份是否存在於隊伍表中
    $check_team_sql = "SELECT * FROM 隊伍 WHERE 隊伍編號 = ? AND 參加年份 = ?";
    $check_team_stmt = mysqli_prepare($link, $check_team_sql);
    mysqli_stmt_bind_param($check_team_stmt, "si", $team_id, $currentYear);
    mysqli_stmt_execute($check_team_stmt);
    $check_result = mysqli_stmt_get_result($check_team_stmt);
    
    if (mysqli_num_rows($check_result) == 0) {
        throw new Exception('隊伍編號或參加年份不存在於隊伍表中，無法新增指導老師資料');
    }

    // 刪除該隊伍的所有學生資料
    $delete_students_sql = "DELETE FROM 學生 WHERE 隊伍編號 = ?";
    $delete_students_stmt = mysqli_prepare($link, $delete_students_sql);
    mysqli_stmt_bind_param($delete_students_stmt, "s", $team_id);
    mysqli_stmt_execute($delete_students_stmt);

    // 刪除該隊伍的指導老師資料
    $delete_professor_sql = "DELETE FROM 指導老師 WHERE 隊伍編號 = ?";
    $delete_professor_stmt = mysqli_prepare($link, $delete_professor_sql);
    mysqli_stmt_bind_param($delete_professor_stmt, "s", $team_id);
    mysqli_stmt_execute($delete_professor_stmt);

    // 新增學生資料
    $insert_student_sql = "
        INSERT INTO 學生 (身分證字號, 學號, 姓名, 電子郵件, 電話, 科系, 年級, 隊伍編號, 參加年份) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_student_stmt = mysqli_prepare($link, $insert_student_sql);

    foreach ($students as $student) {
        mysqli_stmt_bind_param(
            $insert_student_stmt,
            "ssssssssi",
            $student['id'],
            $student['studentid'],
            $student['name'],
            $student['email'],
            $student['phone'],
            $student['department'],
            $student['grade'],
            $team_id,
            $currentYear
        );
        mysqli_stmt_execute($insert_student_stmt);
    }

    // 新增指導老師資料
    if (!empty($professor['id']) && !empty($professor['name'])) {
        $insert_professor_sql = "
            INSERT INTO 指導老師 (身分證字號, 姓名, 電子郵件, 電話, 隊伍編號, 參加年份) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $insert_professor_stmt = mysqli_prepare($link, $insert_professor_sql);
        mysqli_stmt_bind_param(
            $insert_professor_stmt,
            "sssssi",
            $professor['id'],
            $professor['name'],
            $professor['email'],
            $professor['phone'],
            $team_id,
            $currentYear
        );
        mysqli_stmt_execute($insert_professor_stmt);
    }

    // 提交交易
    mysqli_commit($link);

    echo '<h2>資料更新成功！</h2>';
    echo '<form action="student_dashboard.php" method="POST">';
    echo '<input type="hidden" name="username" value="'. $_POST['username'] . '">';
    echo '<input type="hidden" name="password" value="'. $_POST['password'] . '">';
    echo '<button type="submit">返回儀表板</button>';
    echo '</form>';

    echo '</form>';
} catch (Exception $e) {
    // 回滾交易
    mysqli_rollback($link);

    echo '<h2>資料更新失敗，請稍後再試。</h2>';
    echo '<p>錯誤訊息：' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '
        <div class="button-container">    
            <a href="student_dashboard.php" class="system-button">返回儀表板</a>
        </div>';
}

// 關閉連線
mysqli_close($link);
?>
