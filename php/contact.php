<?php
// 山ノ製作所 採用問い合わせフォーム用サンプル
// 本番では送信先メールアドレス、CSRF対策、バリデーション、スパム対策を設定してください。

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    http_response_code(422);
    exit('入力内容をご確認ください。');
}

$to = 'replace@example.com'; // 本番公開前に採用担当者のメールへ変更
$subject = '山ノ製作所 採用サイトからのお問い合わせ';
$body = "氏名: {$name}\nメール: {$email}\n\n{$message}";
$headers = "From: {$email}\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";

if (mail($to, $subject, $body, $headers)) {
    echo 'お問い合わせを受け付けました。';
} else {
    http_response_code(500);
    echo '送信に失敗しました。';
}
