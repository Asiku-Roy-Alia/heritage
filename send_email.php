<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['yourName']);
    $email = htmlspecialchars($_POST['yourEmail']);
    $phone = htmlspecialchars($_POST['yourPhone']);
    $message = htmlspecialchars($_POST['yourMessage']);

    // Email configuration
    $to = "info@heritagehotelsug.com"; // Replace with your email
    $subject = "New Message from Contact Form";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Email content
    $email_body = "
    <html>
    <head>
        <title>New Contact Form Message</title>
    </head>
    <body>
        <h2>Contact Form Message</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong> $message</p>
    </body>
    </html>";

    // Send email
    if (mail($to, $subject, $email_body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
