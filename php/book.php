<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Load configuration settings
$config = require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));
    $tour = htmlspecialchars(trim($_POST['tour']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format';
        exit;
    }

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $config['MAIL_HOST'];                    // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['MAIL_USERNAME'];                 // SMTP username
        $mail->Password   = $config['MAIL_PASSWORD'];                 // SMTP password
        $mail->SMTPSecure = $config['MAIL_ENCRYPTION'];                // Encryption
        $mail->Port       = $config['MAIL_PORT'];                     // Port

        // Recipients
        $mail->setFrom('booking@discoverdubrovnik.com', 'Tour Booking');
        $mail->addAddress('totluka@gmail.com');                      // Add your email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Tour Booking';
        $mail->Body    = "<p>Name: $name</p><p>Email: $email</p><p>Date: $date</p><p>Time: $time</p><p>Tour: $tour</p>";
        $mail->AltBody = "Name: $name\nEmail: $email\nDate: $date\nTime: $time\nTour: $tour";

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request';
}
