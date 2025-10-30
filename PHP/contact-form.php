<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        // Save message to file
        $file = fopen("messages.txt", "a");
        if ($file) {
            $entry = "----- New Message -----\n" .
                     "Date: " . date("Y-m-d H:i:s") . "\n" .
                     "Name: $name\n" .
                     "Email: $email\n" .
                     "Message:\n$message\n\n";
            fwrite($file, $entry);
            fclose($file);
        }

        // Display thank-you and auto-redirect
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Message Sent</title>
            <link rel='stylesheet' href='style.css'>
            <meta http-equiv='refresh' content='3;url=contact.html'>
        </head>
        <body>
            <div class='container'>
                <h1>Thank you, $name!</h1>
                <p>Your message has been successfully sent.</p>
                <p>You’ll be redirected to the contact page shortly.</p>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error</title>
            <link rel='stylesheet' href='style.css'>
            <meta http-equiv='refresh' content='4;url=contact.html'>
        </head>
        <body>
            <div class='container'>
                <h1>Submission Error</h1>
                <p>Please make sure all fields are filled out correctly.</p>
                <p>Redirecting back...</p>
            </div>
        </body>
        </html>";
    }
} else {
    header("Location: contact.html");
    exit;
}
?>

