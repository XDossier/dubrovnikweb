<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure the PHPMailer library is autoloaded

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $date = htmlspecialchars($_POST['date']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->isSMTP(); 
        $mail->Host = 'smtp.elasticemail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'totluka@gmail.com';
        $mail->Password = 'Test123!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // PHPMailer::ENCRYPTION_STARTTLS if using STARTTLS
        $mail->Port = 465; // 587 for PHPMailer::ENCRYPTION_STARTTLS

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('totluka@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Booking Request';
        $mail->Body    = "Name: $name<br>Email: $email<br>Date: $date";

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request';
}
