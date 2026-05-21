<?php
require __DIR__ . '/config.php';

$result = $conn->query('SELECT * FROM emails ORDER BY no ASC');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Email 列表</title>
</head>
<body>
<h1>Email 列表</h1>
<a href="index.php">返回首頁</a> | <a href="add_email.php">新增 Email</a>
<hr>
<?php if ($result->num_rows === 0): ?>
    <p>目前沒有任何 Email 紀錄。</p>
<?php else: ?>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>編號</th>
        <th>Email</th>
        <th>建立時間</th>
        <th>操作</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= (int)$row['no'] ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
        <td>
            <form method="POST" action="delete_email.php">
                <input type="hidden" name="no" value="<?= (int)$row['no'] ?>">
                <input type="submit" value="刪除">
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php endif; ?>
</body>
</html>
