<?php
require __DIR__ . '/config.php';

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no = intval($_POST['no'] ?? 0);
    if ($no > 0) {
        $stmt = $conn->prepare('DELETE FROM emails WHERE no = ?');
        $stmt->bind_param('i', $no);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $msg = '刪除成功（編號 ' . $no . '）';
            } else {
                $err = '找不到編號 ' . $no . ' 的紀錄。';
            }
        } else {
            $err = '刪除失敗：' . $conn->error;
        }
        $stmt->close();
    } else {
        $err = '無效的編號。';
    }
} else {
    $err = '不允許直接存取此頁面。';
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>刪除結果</title>
</head>
<body>
<h1>刪除結果</h1>
<hr>
<?php if ($msg !== ''): ?>
    <p><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>
<?php if ($err !== ''): ?>
    <p>錯誤：<?= htmlspecialchars($err) ?></p>
<?php endif; ?>
<a href="list_emails.php">返回列表</a> | <a href="index.php">返回首頁</a>
</body>
</html>
