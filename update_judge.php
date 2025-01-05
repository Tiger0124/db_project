<?php
include 'conn.php'; // 引入資料庫連線設定

// 檢查是否是 POST 請求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 從表單獲取資料
    $student1_id = $_POST['student1_id']; // 身分證字號
    $student1_name = $_POST['student1_name']; // 姓名
    $student1_email = $_POST['student1_email']; // 電子郵件
    $student1_phone = $_POST['student1_phone']; // 電話
    $student1_department = $_POST['student1_department']; // 頭銜
    $student1_session = $_POST['student1_session']; // 屆數
    $username = $_POST['student1_name']; // 用戶名
    $password = $_POST['student1_id']; // 評審身分證字號（用於檢查）

    // 更新資料庫中的評審資料
    $sql = "UPDATE 評審委員
            SET 姓名 = '$student1_name', 
                電子郵件 = '$student1_email', 
                電話 = '$student1_phone', 
                頭銜 = '$student1_department' 
            WHERE 身分證字號 = '$student1_id' and 屆數 = '$student1_session'" ;

    if (mysqli_query($link, $sql)) {
        // 如果更新成功，顯示成功訊息
        echo "<script>alert('資料更新成功！'); window.location.href = 'main.php';</script>";
    } else {
        // 如果更新失敗，顯示錯誤訊息
        echo "<script>alert('資料更新失敗，請再試一次。'); history.back();</script>";
    }

    // 關閉資料庫連線
    mysqli_close($link);
} else {
    // 如果不是 POST 請求，跳轉回表單頁面
    header('Location: judge_dashboard.php');
    exit();
}
?>
