<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = $_POST['cpass'];
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'User email already exists!';
   } else {
      if($pass != $cpass){
         $message[] = 'Confirm password does not match!';
      } else {
         $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); 
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?, ?, ?, ?)");
         $insert->execute([$name, $email, $hashed_pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'Image size is too large!';
            } else {
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'Registered successfully!';
               header('Location: login.php');
               exit;
            }
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/components.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
   }
}
?>

<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Register Now</h3>
      <input type="text" name="name" class="box" placeholder="Enter your name" required>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Register Now" class="btn" name="submit">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</section>

</body>
</html>
