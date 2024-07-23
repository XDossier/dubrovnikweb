<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent XSS attacks
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $tour = htmlspecialchars($_POST['tour']);

    // Send email notification
    $to = "mtknego@gmail.com"; // Replace with your email address
    $subject = "New Tour Booking";
    $message = "Name: $name\nEmail: $email\nDate: $date\nTime: $time\nTour: $tour";
    $headers = "From: no-reply@yourwebsite.com"; // Replace with your website's email address

    if (mail($to, $subject, $message, $headers)) {
        echo 'success';
    } else {
        echo 'failure';
    }
} else {
    echo 'Invalid request';
}
?>
