<link rel="stylesheet" href="styles.css">
<?php
include 'conn.php';
#接收表單的文字內容
$video_url = $_POST['video_url'];
$code_url = $_POST['code_url'];
$pro_name = $_POST['pro_name'];
$pro_des = $_POST['pro_des'];
$file_content;
$file_content2;
$username =  $_POST['username'];
$password =  $_POST['password'];
$year = date("Y");

#檢查檔案是否存在並處理

if (isset($_FILES['manual_file']) && $_FILES['manual_file']['error'] === UPLOAD_ERR_OK) {
    #檔案資訊
    $file_tmp_name = $_FILES['manual_file']['tmp_name']; #臨時檔案路徑
    $file_name = $_FILES['manual_file']['name'];         #原始檔名
    $file_size = $_FILES['manual_file']['size'];         #檔案大小
    $file_type = $_FILES['manual_file']['type'];         #檔案類型

    #檢查檔案大小(可選)
    if ($file_size > 10 * 1024 * 1024) { #限制10MB
        die("檔案過大，請上傳小於10MB的檔案。");
    }

    #讀取檔案內容並轉換為BLOB
    $file_content = file_get_contents($file_tmp_name);
    $file_content = mysqli_real_escape_string($link, $file_content);
}
if(isset($_FILES['poster_file']) && $_FILES['poster_file']['error'] === UPLOAD_ERR_OK){
    $file_tmp_name = $_FILES['poster_file']['tmp_name']; #臨時檔案路徑
    $file_name = $_FILES['poster_file']['name'];         #原始檔名
    $file_size = $_FILES['poster_file']['size'];         #檔案大小
    $file_type = $_FILES['poster_file']['type'];         #檔案類型

    #檢查檔案大小(可選)
    if ($file_size > 10 * 1024 * 1024) { #限制10MB
        die("檔案過大，請上傳小於10MB的檔案。");
    }

    #讀取檔案內容並轉換為BLOB
    $file_content2 = file_get_contents($file_tmp_name);
    $file_content2 = mysqli_real_escape_string($link, $file_content2);
}

$sql = "INSERT INTO 作品(說明書,海報,作品展示_youtube連結,程式碼_github連結,作品名稱,作品描述,參加年份,隊伍編號) VALUES('".$file_content."','".$file_content2."','".$video_url."','".$code_url."','".$pro_name."','".$pro_des."','".$year."','".$username."')";
$result = mysqli_query($link, $sql);
if ($result) {
    echo "<h2>作品上傳成功！</h2>";
} else {
    echo "<h2>作品上傳失敗！</h2>";
}

echo "<form action='student_dashboard.php' method='POST'>";
echo "<input type='hidden' name='username' value='".$username."'>";
echo "<input type='hidden' name='password' value='".$password."'>";
echo "<button type='submit'>返回</button>";
echo "</form>";
?>