<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1) Sanitize form data
    $yourName    = strip_tags(trim($_POST["yourName"]));
    $yourEmail   = filter_var($_POST["yourEmail"], FILTER_SANITIZE_EMAIL);
    $yourPhone   = strip_tags(trim($_POST["yourPhone"]));
    $yourMessage = strip_tags(trim($_POST["yourMessage"]));

    // 2) Email settings:
    //    - FROM must be a valid local address you own (here: admin@...)
    //    - TO is the mailbox that should receive the message (info@...)
    $fromAddress = "admin@heritagehotelsug.com";
    $toAddress   = "info@heritagehotelsug.com";
    $subject     = "New Contact Form Submission from $yourName";

    // 3) Build headers
    // 'From' is a valid mailbox on your domain,
    // 'Reply-To' is the visitor’s email (makes replying easier)
    $headers  = "From: {$fromAddress}\r\n";
    $headers .= "Reply-To: {$yourEmail}\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // 4) Build the HTML email body
    $email_body = "
    <html>
    <head>
      <title>{$subject}</title>
    </head>
    <body>
      <h2>Contact Form Message</h2>
      <p><strong>Name:</strong> {$yourName}</p>
      <p><strong>Email:</strong> {$yourEmail}</p>
      <p><strong>Phone:</strong> {$yourPhone}</p>
      <p><strong>Message:</strong> {$yourMessage}</p>
    </body>
    </html>";

    // 5) Send
    if (mail($toAddress, $subject, $email_body, $headers)) {
        // If mail is sent successfully
        echo "Email sent successfully.";
        // Or redirect to a thank-you page:
        // header("Location: thank_you.html");
        // exit;
    } else {
        // If mail sending fails
        echo "Error: Email not sent";
    }
}
?>
