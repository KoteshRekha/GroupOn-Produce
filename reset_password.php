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
                    $message = "Password reset successful! <a href='login.php'>Login now</a>";
                } else {
                    $message = "There was an error updating your password. Please try again.";
                }
            } else {
                $message = "Passwords do not match.";
            }
        }
    } else {
        $message = "Invalid or expired token.";
    }
} else {
    $message = "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-container .box {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background: #5cb85c;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .form-container .btn:hover {
            background: #4cae4c;
        }
        .form-container p {
            text-align: center;
            margin-top: 15px;
        }
        .form-container p a {
            color: #5cb85c;
            text-decoration: none;
        }
        .form-container p a:hover {
            text-decoration: underline;
        }
        .message {
            margin-bottom: 15px;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <section class="form-container">
        <?php if (isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>
        <?php if (isset($user)) { ?>
            <form action="" method="POST">
                <h3>Reset Password</h3>
                <input type="password" name="new_password" class="box" placeholder="Enter new password" required>
                <input type="password" name="confirm_password" class="box" placeholder="Confirm new password" required>
                <input type="submit" value="Reset Password" class="btn" name="reset_password">
            </form>
        <?php } ?>
    </section>
</body>
</html>
