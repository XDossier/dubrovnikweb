<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $remarks = $_POST['remarks'];

    // Receiver Email Address (change this to your email)
    $to = "totluka@gmail.com";

    // Email Subject
    $subject = "Message from Contact Form";

    // Email Content
    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Country: $country\n";
    $message .= "Message:\n$remarks\n";

    // Headers
    $headers = "From: $name <$email>";

    // Send Email
    if (mail($to, $subject, $message, $headers)) {
        echo "Your message has been sent successfully.";
    } else {
        echo "Failed to send message. Please try again later.";
    }
}
?>
