<?php

if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
    echo '<h2>歡迎，管理員！</h2>';
    echo '<p>請選擇以下功能：</p>';
    echo '
    <div class="admin-buttons">
        <form action="view_students.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">查詢隊伍資料</button>
        </form>
        <form action="view_judges.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">查詢評審資料</button>
        </form>
        <form action="view_scores.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">查看評分資料</button>
        </form>
        <form action="announcements.php" method="POST">
            <input type="hidden" name="username" value="' . $_POST['username'] . '">
            <input type="hidden" name="password" value="' . $_POST['password'] . '">
            <button type="submit">公告重要事項</button>
        </form>
    </div>';
} else {
    echo '<p>登入失敗，請返回並重試。</p>';
    echo '<a href="admin.php">返回</a>';
}
?>
