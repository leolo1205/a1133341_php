<?php
session_start();
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "root" && $password === "password") {
        $_SESSION["is_login"] = true;
        header("Location: register.php");
        exit();
    } else {
        $error_msg = "登入失敗：帳號或密碼錯誤！";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>系統登入</title>
</head>
<body>
    <h2>系統登入</h2>
    
    <?php if ($error_msg != ""): ?>
        <p style="color: red;"><?php echo $error_msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>帳號：</label>
        <input type="text" name="username" required><br><br>
        
        <label>密碼：</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">登入</button>
    </form>
</body>
</html>