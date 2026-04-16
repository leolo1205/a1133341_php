<?php
session_start();

$isLoggedIn = !empty($_SESSION["is_login"]);
$isAdmin = (($_SESSION["role"] ?? "") === "admin");
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <?php if (!$isLoggedIn): ?>
        <meta http-equiv="refresh" content="5;url=login.php">
    <?php elseif (!$isAdmin): ?>
        <meta http-equiv="refresh" content="5;url=index.php">
    <?php endif; ?>
    <title>管理者頁面</title>
</head>
<body style="font-family: Microsoft JhengHei, sans-serif; padding: 40px;">
    <?php if (!$isLoggedIn): ?>
        <h1 style="color: #b71c1c;">警告</h1>
        <p>請先登入後再進入管理者專屬頁面。</p>
        <p>系統將在 5 秒後自動回到登入頁。</p>
        <p><a href="login.php">立即返回</a></p>
    <?php elseif (!$isAdmin): ?>
        <h1 style="color: #b71c1c;">警告</h1>
        <p>非法進入管理者專屬頁面。</p>
        <p>系統將在 5 秒後自動回到首頁。</p>
        <p><a href="index.php">立即返回</a></p>
    <?php else: ?>
        <h1>管理者專屬頁面</h1>
        <p>只有管理者角色可以觀看這個頁面。</p>
        <p><a href="index.php">回首頁</a></p>
    <?php endif; ?>
</body>
</html>
