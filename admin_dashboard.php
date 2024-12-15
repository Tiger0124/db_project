<?php
if ($_POST['username'] === 'admin' && $_POST['password'] === '1234') {
    echo '<h2>歡迎，管理員！</h2>';
    echo '<p>請選擇以下功能：</p>';
    echo '
    <div class="admin-buttons">
        <a href="view_students.php">查詢學生資料</a>
        <a href="edit_students.php">修改報名資料</a>
        <a href="view_judges.php">查詢評審資料</a>
        <a href="view_scores.php">查看評分資料</a>
        <a href="announcements.php">公告重要事項</a>
    </div>';
} else {
    echo '<p>登入失敗，請返回並重試。</p>';
    echo '<a href="index.php?page=admin">返回</a>';
}
?>
