<?php
// 引入資料庫連線
include 'conn.php';

// 查詢當前最大隊伍編號
$sql = "SELECT MAX(隊伍編號) AS max_id FROM 隊伍 WHERE 參加年份 = " . date("Y");
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

$max_id = $row['max_id'] ?? 'T000'; // 如果資料表為空，預設為 'T000'

// 解析並生成下一個編號
$next_num = (int)substr($max_id, 1) + 1; // 提取數字部分並加 1
$team_num = 'T' . str_pad($next_num, 3, '0', STR_PAD_LEFT); // 補齊 3 位數

// 檢查表單是否以 POST 提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 隊伍資料
    $team_name = mysqli_real_escape_string($link, $_POST['team_name']);
    $currentYear = date("Y");
    $yearToSession = [
        2013 => "第1屆",
        2014 => "第2屆",
        2015 => "第3屆",
        2016 => "第4屆",
        2017 => "第5屆",
        2018 => "第6屆",
        2019 => "第7屆",
        2020 => "第8屆",
        2021 => "第9屆",
        2022 => "第10屆",
        2023 => "第11屆",
        2024 => "第12屆",
        2025 => "第13屆"
    ];
    $session = $yearToSession[$currentYear];

    // 插入隊伍資料
    $sql_team = "INSERT INTO 隊伍 (參加年份, 隊伍編號, 隊伍名稱, 名次, 屆數) VALUES ('$currentYear', '$team_num', '$team_name', NULL, '$session')";
    if (!mysqli_query($link, $sql_team)) {
        die("隊伍資料插入失敗：" . mysqli_error($link));
    }

    // 學生資料
    for ($i = 1; $i <= 4; $i++) {
        $student_id = $_POST["student{$i}_id"] ?? null;
        $student_num = $_POST["student{$i}_num"] ?? null;
        $student_name = $_POST["student{$i}_name"] ?? null;
        $student_email = $_POST["student{$i}_email"] ?? null;
        $student_phone = $_POST["student{$i}_phone"] ?? null;
        $student_department = $_POST["student{$i}_department"] ?? null;
        $student_grade = $_POST["student{$i}_grade"] ?? null;

        // 如果是學生 4，檢查是否有輸入資料，若無則跳過
        if ($i === 4 && empty($student_id) && empty($student_num) && empty($student_name)) {
            continue;
        }

        // 插入學生資料
        $sql_student = "INSERT INTO 學生 (姓名, 身分證字號, 科系, 電話, 電子郵件, 年級, 學號, 參加年份, 隊伍編號) 
                        VALUES ('$student_name', '$student_id', '$student_department', '$student_phone', '$student_email', 
                                '$student_grade', '$student_num', '$currentYear', '$team_num')";
        if (!mysqli_query($link, $sql_student)) {
            die("學生資料插入失敗：" . mysqli_error($link));
        }
    }

    // 指導教授資料
    $professor_id = mysqli_real_escape_string($link, $_POST['professor_id']);
    $professor_name = mysqli_real_escape_string($link, $_POST['professor_name']);
    $professor_email = mysqli_real_escape_string($link, $_POST['professor_email']);
    $professor_phone = mysqli_real_escape_string($link, $_POST['professor_phone']);

    // 插入教授資料
    $sql_professor = "INSERT INTO 指導老師 (姓名, 電話, 電子郵件, 身分證字號, 參加年份, 隊伍編號) 
                      VALUES ('$professor_name', '$professor_phone', '$professor_email', '$professor_id', '$currentYear', '$team_num')";
    if (!mysqli_query($link, $sql_professor)) {
        die("教授資料插入失敗：" . mysqli_error($link));
    }

    // 報名成功訊息
    echo "<h2>報名成功！</h2>";
    echo "<p>隊伍名稱：$team_name</p>";
    echo "<a href='main.php'>返回主頁</a>";
} else {
    // 如果不是 POST 提交，跳轉回表單頁面
    header('Location: main.php');
    exit();
}
?>
