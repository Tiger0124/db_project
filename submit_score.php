<?php
// 連接資料庫
include 'conn.php';

// 檢查是否有提交表單
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 遍歷提交的所有數據
    foreach ($_POST as $key => $value) {
        // 判斷是否為評分欄位
        if (strpos($key, 'score') === 0) {
            // 擷取隊伍編號
            $teamId = str_replace('score', '', $key);
            $score = intval($value); // 確保評分為整數

            // 插入或更新評分資料表
            $sql = "INSERT INTO 評分資料 (評分, 隊伍編號) 
                    VALUES ('$score', '$teamId')
                    ON DUPLICATE KEY UPDATE 評分 = '$score'";

            // 執行 SQL 語句
            if (mysqli_query($link, $sql)) {
                echo "評分提交成功：隊伍 $teamId 的分數為 $score。<br>";
            } else {
                echo "提交失敗：隊伍 $teamId 的分數無法保存。" . mysqli_error($link) . "<br>";
            }
        }
    }
} else {
    echo "無效的請求方式。";
}

// 關閉資料庫連接
mysqli_close($link);
?>
