<?php

@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit();
}

$message = []; // Initialize message array for displaying notifications

if (isset($_POST['add_to_wishlist'])) {

    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_name = filter_var($_POST['p_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_price = filter_var($_POST['p_price'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_image = filter_var($_POST['p_image'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist->execute([$p_name, $user_id]);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart->execute([$p_name, $user_id]);

    if ($check_wishlist->rowCount() > 0) {
        $message[] = 'Already added to wishlist!';
    } elseif ($check_cart->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, pid, name, price, image) VALUES (?, ?, ?, ?, ?)");
        $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
        $message[] = 'Added to wishlist!';
    }
}

if (isset($_POST['add_to_cart'])) {

    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_name = filter_var($_POST['p_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_price = filter_var($_POST['p_price'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_image = filter_var($_POST['p_image'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $p_qty = filter_var($_POST['p_qty'], FILTER_SANITIZE_NUMBER_INT);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart->execute([$p_name, $user_id]);

    if ($check_cart->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {

        $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist->execute([$p_name, $user_id]);

        if ($check_wishlist->rowCount() > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$p_name, $user_id]);
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
        $message[] = 'Added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'header.php'; ?>

<section class="p-category">
   <a href="category.php?category=fruits">Fruits</a>
   <a href="category.php?category=vegetables">Vegetables</a>
   <a href="category.php?category=fish">Fish</a>
   <a href="category.php?category=meat">Meat</a>
</section>

<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC");
      $select_products->execute();

      if ($select_products->rowCount() > 0) {
         while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) { 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= htmlspecialchars($fetch_product['price']); ?></span>/-</div>
      <a href="view_page.php?pid=<?= htmlspecialchars($fetch_product['id']); ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= htmlspecialchars($fetch_product['image']); ?>" alt="Product Image">
      <div class="name"><?= htmlspecialchars($fetch_product['name']); ?></div>

      <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_product['id']); ?>">
      <input type="hidden" name="p_name" value="<?= htmlspecialchars($fetch_product['name']); ?>">
      <input type="hidden" name="p_price" value="<?= htmlspecialchars($fetch_product['price']); ?>">
      <input type="hidden" name="p_image" value="<?= htmlspecialchars($fetch_product['image']); ?>">

      <?php if ($fetch_product['stock'] > 0) { ?>
         <input type="number" min="1" max="<?= htmlspecialchars($fetch_product['stock']); ?>" value="1" name="p_qty" class="qty">
         <input type="submit" value="Add to Wishlist" class="option-btn" name="add_to_wishlist">
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      <?php } else { ?>
         <p class="out-of-stock">Out of Stock</p>
      <?php } ?>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products available yet!</p>';
      }
   ?>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>

</html>
