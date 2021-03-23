<?php

function send_mail(string $subject, string $to, string $message)
{
    $headers = 'From: webmaster@camagru.com' . "\r\n" .
        'Reply-To: webmaster@camagru.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}