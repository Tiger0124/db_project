<?php
$works = [
    100 => [['隊伍A', '作品A說明書'], ['隊伍B', '作品B說明書']],
    101 => [['隊伍C', '作品C說明書'], ['隊伍D', '作品D說明書']],
    102 => [['隊伍E', '作品E說明書'], ['隊伍F', '作品F說明書']],
];
$year = isset($_GET['year']) ? (int)$_GET['year'] : 100;
?>
<h2>歷屆作品瀏覽</h2>
<form method="GET" action="student_history.php">
    <label for="year">選擇年份：</label>
        <select id="year" name="year">
        <option value="100" <?= $year === 100 ? 'selected' : '' ?>>100 年</option>
        <option value="101" <?= $year === 101 ? 'selected' : '' ?>>101 年</option>
        <option value="102" <?= $year === 102 ? 'selected' : '' ?>>102 年</option>
    </select>
    <button type="submit">查詢</button>
    </form>
<?php if (isset($works[$year])): ?>
    <table border="1">
    <tr>
        <th>隊伍名稱</th>
        <th>作品說明</th>
    </tr>
    <?php foreach ($works[$year] as $work): ?>
        <tr>
        <td><?= htmlspecialchars($work[0]) ?></td>
        <td><?= htmlspecialchars($work[1]) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>該年份無作品資料。</p>
<?php endif; ?>