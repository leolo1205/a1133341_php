<?php
set_time_limit(0);

require __DIR__ . '/config.php';
require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_name    = trim($_POST['sender_name']    ?? '');
    $subject        = trim($_POST['subject']        ?? '');
    $body           = trim($_POST['body']           ?? '');
    $send_mode      = $_POST['send_mode']      ?? 'all';
    $all_count      = max(1, intval($_POST['all_count']     ?? 1));
    $random_count   = max(1, intval($_POST['random_count']  ?? 1));
    $interval_mode  = $_POST['interval_mode']  ?? 'fixed';
    $fixed_interval = max(0, intval($_POST['fixed_interval'] ?? 0));
    $min_interval   = max(0, intval($_POST['min_interval']   ?? 0));
    $max_interval   = max(0, intval($_POST['max_interval']   ?? 0));

    // 清除輸出緩衝，啟用串流輸出
    while (ob_get_level()) ob_end_clean();

    echo '<!DOCTYPE html><html lang="zh-Hant"><head><meta charset="UTF-8"><title>寄送郵件</title></head><body>';
    echo '<h1>寄送郵件</h1>';
    echo '<a href="index.php">返回首頁</a> | <a href="list_emails.php">Email 列表</a>';
    echo '<hr>';
    // 瀏覽器緩衝填充（確保串流即時顯示）
    echo str_repeat(' ', 1024);
    flush();

    if ($subject === '' || $body === '') {
        echo '<p>錯誤：主旨與內容不能為空白。</p>';
    } else {
        $res    = $conn->query('SELECT * FROM emails ORDER BY no ASC');
        $emails = [];
        while ($row = $res->fetch_assoc()) {
            $emails[] = $row;
        }

        if (empty($emails)) {
            echo '<p>錯誤：資料庫中沒有任何 Email 紀錄。</p>';
        } else {
            if ($send_mode === 'all') {
                // 每人重複寄 N 封
                $repeated = [];
                foreach ($emails as $row) {
                    for ($n = 0; $n < $all_count; $n++) {
                        $repeated[] = $row;
                    }
                }
                $emails = $repeated;
            } else {
                // 隨機挑 N 筆，不足則循環補足
                $base     = $emails;
                $selected = [];
                while (count($selected) < $random_count) {
                    shuffle($base);
                    foreach ($base as $item) {
                        $selected[] = $item;
                        if (count($selected) >= $random_count) break;
                    }
                }
                $emails = $selected;
            }

            $total_count = count($emails);
            $success     = 0;
            $failure     = 0;
            $results     = [];

            echo '<h2>寄送進度</h2>';
            echo '<table border="1" cellpadding="5" cellspacing="0">';
            echo '<tr><th>進度</th><th>Email</th><th>狀態</th><th>訊息</th></tr>';
            flush();

            foreach ($emails as $i => $row) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host     = $smtp_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_username;
                    $mail->Password = $smtp_password;
                    $mail->Port     = $smtp_port;
                    $mail->CharSet  = 'UTF-8';

                    if ($smtp_encryption === 'ssl') {
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMIME;
                    } else {
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    }

                    $mail->setFrom($smtp_username, $sender_name);
                    $mail->addAddress($row['email']);
                    $mail->Subject = $subject;
                    $mail->Body    = $body;

                    $mail->send();
                    $success++;
                    $status = '成功';
                    $msg    = '寄送成功';
                } catch (Exception $e) {
                    $failure++;
                    $status = '失敗';
                    $msg    = $mail->ErrorInfo;
                }

                $progress = ($i + 1) . '/' . $total_count;
                echo '<tr>';
                echo '<td>' . $progress . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . $status . '</td>';
                echo '<td>' . htmlspecialchars($msg) . '</td>';
                echo '</tr>';
                flush();

                // 間隔等待（最後一封不等待）
                if ($i < $total_count - 1) {
                    if ($interval_mode === 'random') {
                        $hi   = max($min_interval, $max_interval);
                        $wait = rand($min_interval, $hi);
                    } else {
                        $wait = $fixed_interval;
                    }
                    if ($wait > 0) sleep($wait);
                }
            }

            echo '</table>';
            echo '<p><strong>寄送完成：成功 ' . $success . ' 封 &nbsp; 失敗 ' . $failure . ' 封 &nbsp; 共計 ' . $total_count . ' 封</strong></p>';
            flush();
        }
    }

    echo '<hr>';
    echo '<a href="send_mail.php">重新寄送</a> | <a href="index.php">返回首頁</a>';
    echo '</body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>寄送郵件</title>
</head>
<body>
<h1>寄送郵件</h1>
<a href="index.php">返回首頁</a> | <a href="list_emails.php">Email 列表</a>
<hr>

<h2>填寫寄件資訊</h2>
<form method="POST" action="">

    <p>
        <label>寄件人名稱：<br>
            <input type="text" name="sender_name" value="" required>
        </label>
    </p>

    <p>
        <label>主旨：<br>
            <input type="text" name="subject" size="50" value="" required>
        </label>
    </p>

    <p>
        <label>內文：<br>
            <textarea name="body" rows="6" cols="60"></textarea>
        </label>
    </p>

    <fieldset>
        <legend>寄送模式</legend>
        <label>
            <input type="radio" name="send_mode" value="all" checked>
            全部寄送，每人封數：
            <input type="number" name="all_count" min="1" value="1">
        </label>
        <br><br>
        <label>
            <input type="radio" name="send_mode" value="random">
            隨機寄送，筆數：
            <input type="number" name="random_count" min="1" value="1">
        </label>
    </fieldset>

    <br>

    <fieldset>
        <legend>寄送間隔</legend>
        <label>
            <input type="radio" name="interval_mode" value="fixed" checked>
            固定間隔（秒）：
            <input type="number" name="fixed_interval" min="0" value="0">
        </label>
        <br><br>
        <label>
            <input type="radio" name="interval_mode" value="random">
            隨機間隔（秒）：最小
            <input type="number" name="min_interval" min="0" value="0">
            ～ 最大
            <input type="number" name="max_interval" min="0" value="0">
        </label>
    </fieldset>

    <br>
    <input type="submit" value="開始寄送">
</form>
</body>
</html>
