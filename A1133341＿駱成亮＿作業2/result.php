<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>報名結果</title>
</head>
<body>
    <h2>報名成功！以下是您的報名資料：</h2>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p><strong>姓名：</strong> " . htmlspecialchars($_POST["name"]) . "</p>";
        echo "<p><strong>性別：</strong> " . htmlspecialchars($_POST["gender"]) . "</p>";
        echo "<p><strong>生日：</strong> " . htmlspecialchars($_POST["birthday"]) . "</p>";
        echo "<p><strong>年齡：</strong> " . htmlspecialchars($_POST["age"]) . "</p>";
        echo "<p><strong>電子郵件：</strong> " . htmlspecialchars($_POST["email"]) . "</p>";
        echo "<p><strong>聯絡電話：</strong> " . htmlspecialchars($_POST["phone"]) . "</p>";
        echo "<p><strong>興趣活動：</strong> ";
        if (isset($_POST["activities"]) && !empty($_POST["activities"])) {
            echo htmlspecialchars(implode("、", $_POST["activities"]));
        } else {
            echo "無";
        }
        echo "</p>";
        
        echo "<p><strong>餐點需求：</strong> " . htmlspecialchars($_POST["meal"]) . "</p>";
        echo "<hr>";
        echo "<p><strong>緊急聯絡人：</strong> " . htmlspecialchars($_POST["emergency_contact"]) . "</p>";
        echo "<p><strong>緊急聯絡電話：</strong> " . htmlspecialchars($_POST["emergency_phone"]) . "</p>";
        echo "<p><strong>特殊需求或備註：</strong><br>" . nl2br(htmlspecialchars($_POST["special_needs"])) . "</p>";
    } else {
        echo "<p>沒有收到報名資料，請回上一頁重新填寫。</p>";
    }
    ?>
</body>
</html>