<?php
    $to = $_SESSION['email'];
    $subject = "Hardware 101 - Forgot your password!";
    $newPass = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);

    $message = "
    <html>
    <head>
    <title>Hardware 101 - Forgot your password!</title>
    </head>
    <body>
    <p>So it seems lke you have forgotten your password. Don't worry, it happens to the best of us.</p>
    <p>Because we like to be secure, we have changed your password to something random. Here it is: " . $newPass . "</p>
    <p>When you have logged in, we would suggest changing your password to something you'll remember so we don't have to do this again!</P
    <p>Thanks for using our website, it's greatly appreciated!</p>
    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <webmaster@example.com>' . "\r\n";

    mail($to,$subject,$message,$headers);
?>