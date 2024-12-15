<?php

if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
    echo '<h2>歡迎，xx教授！</h2>';
    echo '<p>請選擇以下功能：</p>';
    echo '
    <div class="admin-buttons">
        <form action="teacher_view.php" method="post">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <input type="submit" value="查看指導學生資料">
        </form>
        <form action="student_history.php" method="post">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <input type="submit" value="查看歷屆作品">
        </form>
    </div>';
} else {
    echo '<p>登入失敗，請返回並重試。</p>';
    echo '<a href="student_login.php">返回</a>';
}
?>
