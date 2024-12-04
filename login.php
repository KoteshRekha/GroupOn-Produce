<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email input
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); // Sanitize password input

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if (password_verify($pass, $row['password'])) { // Verifying the password
            if ($row['user_type'] === 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                header('Location: admin_page.php');
                exit;
            } elseif ($row['user_type'] === 'user') {
                $_SESSION['user_id'] = $row['id'];
                header('Location: home.php');
                exit;
            }
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'No user found!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/components.css">
</head>
<body>

<?php
if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
   }
}
?>

<section class="form-container">
   <form action="" method="POST">
      <h3>Login Now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="submit" value="Login Now" class="btn" name="submit">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
      <p><a href="forgot_password.php" class="forgot-password">Forgot Password?</a></p>
   </form>
</section>

</body>
</html>
