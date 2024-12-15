<?php

if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
    echo '<h2>歡迎，組名！</h2>';
    echo '<p>請選擇以下功能：</p>';
    echo '
    <div class="admin-buttons">
        <a href="student_info.php">修改團隊資訊</a>
        <a href="student_sign_up.php">報名系統</a>
        <a href="student_history.php">歷屆作品瀏覽</a>
    </div>';
} else {
    echo '<p>登入失敗，請返回並重試。</p>';
    echo '<a href="student_login.php">返回</a>';
}
?>
