<?php
require __DIR__ . '/config.php';

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = 'Email 格式不正確，請重新輸入。';
    } else {
        $stmt = $conn->prepare('INSERT INTO emails (email) VALUES (?)');
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $msg = 'Email 新增成功：' . htmlspecialchars($email);
        } else {
            $err = '新增失敗：' . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增 Email</title>
</head>
<body>
<h1>新增 Email</h1>
<a href="index.php">返回首頁</a> | <a href="list_emails.php">Email 列表</a>
<hr>
<?php if ($msg !== ''): ?>
    <p><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>
<?php if ($err !== ''): ?>
    <p>錯誤：<?= htmlspecialchars($err) ?></p>
<?php endif; ?>
<form method="POST" action="">
    <label>Email 地址：
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
    </label>
    <input type="submit" value="新增">
</form>
</body>
</html>
