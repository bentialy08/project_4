<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $comment = htmlspecialchars(trim($_POST['comment'] ?? ''));

    if (!$email) {
        die("Invalid email address.");
    }

    $toEmail = 'bentialy@gmail.com';
    $emailSubject = 'Site contact form';

    // Prepare email headers
    $mailHeader = "From: $email\r\n";
    $mailHeader .= "Reply-To: $email\r\n";
    $mailHeader .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Prepare HTML message body
    $messageBody = "
        <html>
        <head><title>Contact Form Submission</title></head>
        <body>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Comment:</strong><br>" . nl2br($comment) . "</p>
        </body>
        </html>
    ";

    // Wordwrap message to 70 characters per line (optional)
    $messageBody = wordwrap($messageBody, 70);

    // Send the email
    if (mail($toEmail, $emailSubject, $messageBody, $mailHeader)) {
        echo "Message sent successfully.";
    } else {
        echo "Failed to send message.";
    }
} else {
    echo "Invalid request.";
}
?>
