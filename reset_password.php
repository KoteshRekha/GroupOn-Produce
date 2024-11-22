<?php
@include 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token = filter_var($token, FILTER_SANITIZE_STRING); // Sanitize token input

    // Check if token is valid and not expired
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE reset_token = ? AND token_expiration > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Form is submitted to reset the password
        if (isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Sanitize password input
            $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);
            $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password and reset the token in the database
                $updatePassword = $conn->prepare("UPDATE `users` SET password = ?, reset_token = NULL, token_expiration = NULL WHERE reset_token = ?");
                $updatePassword->execute([$hashed_password, $token]);

                if ($updatePassword) {
                    echo "Password reset successful! <a href='login.php'>Login now</a>";
                } else {
                    echo "There was an error updating your password. Please try again.";
                }
            } else {
                echo "Passwords do not match.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form action="" method="POST">
        <h3>Reset Password</h3>
        <input type="password" name="new_password" class="box" placeholder="Enter new password" required>
        <input type="password" name="confirm_password" class="box" placeholder="Confirm new password" required>
        <input type="submit" value="Reset Password" class="btn" name="reset_password">
    </form>
</body>
</html>
