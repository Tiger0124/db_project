<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作品上傳結果 - 高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="submit_project.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="main.php" alt="Logo" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
            </a>
            <h1>高雄大學激發學生創意競賽管理系統</h1>
        </div>
    </header>

    <main id="content">
        <?php
        // 設定台灣時區
        date_default_timezone_set('Asia/Taipei');
        
        include 'conn.php';
        
        // 接收表單的文字內容
        $video_url = $_POST['video_url'];
        $code_url = $_POST['code_url'];
        $pro_name = $_POST['pro_name'];
        $pro_des = $_POST['pro_des'];
        $file_content = null;
        $file_content2 = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $year = date("Y");
        
        $upload_success = true;
        $error_message = "";

        // 檢查說明書檔案
        if (isset($_FILES['manual_file']) && $_FILES['manual_file']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_name = $_FILES['manual_file']['tmp_name'];
            $file_name = $_FILES['manual_file']['name'];
            $file_size = $_FILES['manual_file']['size'];
            $file_type = $_FILES['manual_file']['type'];

            if ($file_size > 10 * 1024 * 1024) {
                $upload_success = false;
                $error_message = "說明書檔案過大，請上傳小於10MB的檔案。";
            } else {
                $file_content = file_get_contents($file_tmp_name);
                $file_content = mysqli_real_escape_string($link, $file_content);
            }
        } else {
            $upload_success = false;
            $error_message = "請上傳說明書檔案。";
        }

        // 檢查海報檔案
        if ($upload_success && isset($_FILES['poster_file']) && $_FILES['poster_file']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_name = $_FILES['poster_file']['tmp_name'];
            $file_name = $_FILES['poster_file']['name'];
            $file_size = $_FILES['poster_file']['size'];
            $file_type = $_FILES['poster_file']['type'];

            if ($file_size > 10 * 1024 * 1024) {
                $upload_success = false;
                $error_message = "海報檔案過大，請上傳小於10MB的檔案。";
            } else {
                $file_content2 = file_get_contents($file_tmp_name);
                $file_content2 = mysqli_real_escape_string($link, $file_content2);
            }
        } else if ($upload_success) {
            $upload_success = false;
            $error_message = "請上傳海報檔案。";
        }

        // 如果檔案上傳成功，則插入資料庫
        if ($upload_success) {
            $sql = "INSERT INTO 作品(說明書,海報,作品展示_youtube連結,程式碼_github連結,作品名稱,作品描述,參加年份,隊伍編號) 
                    VALUES('".$file_content."','".$file_content2."','".$video_url."','".$code_url."','".$pro_name."','".$pro_des."','".$year."','".$username."')";
            $result = mysqli_query($link, $sql);
            
            if ($result) {
                echo '<div class="result-container success">';
                echo '<div class="result-icon success-icon">✓</div>';
                echo '<h2 class="result-title success-title">作品上傳成功！</h2>';
                echo '<div class="result-details">';
                echo '<p><strong>作品名稱：</strong>' . htmlspecialchars($pro_name) . '</p>';
                echo '<p><strong>上傳時間：</strong>' . date('Y-m-d H:i:s') . '</p>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="result-container error">';
                echo '<div class="result-icon error-icon">✗</div>';
                echo '<h2 class="result-title error-title">作品上傳失敗！</h2>';
                echo '<div class="result-details">';
                echo '<p>資料庫錯誤：' . mysqli_error($link) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="result-container error">';
            echo '<div class="result-icon error-icon">✗</div>';
            echo '<h2 class="result-title error-title">作品上傳失敗！</h2>';
            echo '<div class="result-details">';
            echo '<p>' . $error_message . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>

        <div class="action-section">
            <form action="student_dashboard.php" method="POST" class="return-form">
                <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                <button type="submit" class="return-btn">返回主頁</button>
            </form>
        </div>
    </main>

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
</body>
</html>
