<?php
// ── 資料庫設定 ──────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'email_system');

// ── SMTP 設定 ────────────────────────────────────────
$smtp_host       = 'smtp.gmail.com';
$smtp_port       = 587;
$smtp_username   = 'a1133341@mail.nuk.edu.tw';   // 改成你的 Gmail
$smtp_password   = '不跟你講:)'; // 改成應用程式密碼
$smtp_encryption = 'tls';              // 'tls' 或 'ssl'

// ── 資料庫連線 ───────────────────────────────────────
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('資料庫連線失敗：' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
