<?php
@include 'config.php';
require 'vendor/autoload.php'; // Ensure PHPMailer is autoloaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    // Get the email from the form
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    // Check if email exists in the database
    $sql = "SELECT * FROM `users` WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        // Generate a secure token
        $token = bin2hex(random_bytes(50)); // Generate a secure token
        $token_expiration = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expiration time (1 hour)

        // Save the token and expiration in the database
        $updateToken = $conn->prepare("UPDATE `users` SET reset_token = ?, token_expiration = ? WHERE email = ?");
        $updateToken->execute([$token, $token_expiration, $email]);

        // Create reset link
        $resetLink = "http://localhost//GroupOn-Produce/reset_password.php?token=$token"; // Ensure this matches your local dev URL

        // Send reset email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();  // Use SMTP
            $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server (Temp-Mail will work if using valid SMTP details)
            $mail->SMTPAuth = true;  // Enable SMTP authentication
            $mail->Username = 'piyaaarjap@gmail.com';  // Your Gmail address or SMTP service email
            $mail->Password = 'gtvq mzzo ukzt vkzr';  // Use your Gmail App Password or the SMTP service password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Encryption method
            $mail->Port = 587;  // TLS Port for Gmail or SMTP service

            // Recipients
            $mail->setFrom('no-reply@yourwebsite.com', 'Your Website');  // Sender email
            $mail->addAddress($email);  // Recipient email (the Temp-Mail address)

            // Email content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Hello, <br><br>You requested to reset your password. Click the link below to reset it:<br><br>
            <a href='$resetLink'>$resetLink</a><br><br>If you did not request this, please ignore this email.";

            $mail->send();  // Send the email
            echo "A password reset link has been sent to your email!";
        } catch (Exception $e) {
            echo "Failed to send the email. Mailer Error: {$mail->ErrorInfo}";  // Error handling
        }
    } else {
        echo "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/components.css"> <!-- Link your CSS file -->
</head>
<body>

<section class="form-container">
    <form action="" method="POST">
        <h3>Forgot Password</h3>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="submit" value="Submit" class="btn" name="submit">
        <p>Remembered your password? <a href="login.php">Login now</a></p>
    </form>
</section>

</body>
</html>
