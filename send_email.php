<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1) Basic sanitization
    function safeStr($str) {
        return strip_tags(trim($str));
    }

    $yourName    = safeStr($_POST["yourName"]  ?? '');
    $yourEmail   = filter_var($_POST["yourEmail"] ?? '', FILTER_SANITIZE_EMAIL);
    $yourPhone   = safeStr($_POST["yourPhone"] ?? '');
    $yourMessage = safeStr($_POST["yourMessage"] ?? '');

    // 2) Server-side checks to reduce spam:
    //    a) Name: letters & spaces only, min 10 chars
    if (!preg_match("/^[a-zA-Z\s]{10,}$/", $yourName)) {
        exit("Error: Name must be at least 10 letters/spaces, no special chars.");
    }

    //    b) Email: must be valid format
    if (!filter_var($yourEmail, FILTER_VALIDATE_EMAIL)) {
        exit("Error: Invalid email address.");
    }

    //    c) Phone: must start with + and digits, length check
    if (!preg_match("/^\+\d{6,15}$/", $yourPhone)) {
        exit("Error: Phone must start with + and have 6–15 digits.");
    }

    //    d) Message: at least 15 chars, no obvious links
    if (strlen($yourMessage) < 15) {
        exit("Error: Message is too short (min 15 chars).");
    }
    // Quick spam check: no 'http' or 'www' link patterns
    if (preg_match("/(http|www)\:\/\/|<a /i", $yourMessage)) {
        exit("Error: Links are not allowed in the message.");
    }

    // 3) Email settings
    $fromAddress = "admin@heritagehotelsug.com"; // must exist on your domain
    $toAddress   = "info@heritagehotelsug.com";  // recipient
    $subject     = "New Contact Form Submission from $yourName";

    // 4) Build headers
    $headers  = "From: {$fromAddress}\r\n";
    $headers .= "Reply-To: {$yourEmail}\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // 5) Build HTML body
    $email_body = "
    <html>
    <head><title>{$subject}</title></head>
    <body>
      <h2>New Contact Form Message</h2>
      <p><strong>Name:</strong> {$yourName}</p>
      <p><strong>Email:</strong> {$yourEmail}</p>
      <p><strong>Phone:</strong> {$yourPhone}</p>
      <p><strong>Message:</strong> {$yourMessage}</p>
    </body>
    </html>";

    // 6) Attempt sending
    if (@mail($toAddress, $subject, $email_body, $headers)) {
        echo "Email sent successfully. We will get back to you soon.";
    } else {
        echo "Error: Could not send email. Please try again later.";
    }
} 
?>
