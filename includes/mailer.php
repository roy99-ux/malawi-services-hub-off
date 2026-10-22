<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/db.php';

function sendConfiguredEmail(string $recipient, string $subject, string $body): void {
    $db = getDb();
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_encryption')");
    $settings = [];
    foreach ($stmt->fetchAll() as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    $host = trim($settings['smtp_host'] ?? '');
    $port = filter_var($settings['smtp_port'] ?? 587, FILTER_VALIDATE_INT);
    $username = trim($settings['smtp_user'] ?? '');
    $password = $settings['smtp_pass'] ?? '';
    $encryption = strtolower(trim($settings['smtp_encryption'] ?? 'tls'));

    if ($host === '' || !$port || $port > 65535 || $username === '' || $password === '') {
        throw new RuntimeException('SMTP settings are incomplete.');
    }
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('SMTP user must be a valid email address.');
    }
    if (!in_array($encryption, ['tls', 'ssl', 'none'], true)) {
        throw new RuntimeException('SMTP encryption must be TLS, SSL, or none.');
    }

    $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mailer->isSMTP();
    $mailer->Host = $host;
    $mailer->Port = $port;
    $mailer->SMTPAuth = true;
    $mailer->Username = $username;
    $mailer->Password = $password;
    if ($encryption === 'tls') {
        $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($encryption === 'ssl') {
        $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mailer->SMTPAutoTLS = false;
        $mailer->SMTPSecure = '';
    }
    $mailer->CharSet = \PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8;
    $mailer->setFrom($username, 'Malawi Service Hub');
    $mailer->addAddress($recipient);
    $mailer->Subject = $subject;
    $mailer->Body = $body;
    $mailer->send();
}
