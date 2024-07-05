<?php

@include 'config.php';

session_start();


if(!isset($_SESSION['user_id'])){
//    header('location:login.php');
};



    if(isset($_POST['add_to_wishlist'])){
   
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$p_name, $_SESSION['user_id']]);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $_SESSION['user_id']]);

    if($check_wishlist_numbers->rowCount() > 0){
        $message[] = 'already added to wishlist!';
    }elseif($check_cart_numbers->rowCount() > 0){
        $message[] = 'already added to cart!';
    }else{
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$_SESSION['user_id'], $pid, $p_name, $p_price, $p_image]);
        $message[] = 'added to wishlist!';
    }

    }


    if(isset($_POST['add_to_cart'])){

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name, $_SESSION['user_id']]);

    if($check_cart_numbers->rowCount() > 0){
        $message[] = 'already added to cart!';
    }else{

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$p_name, $_SESSION['user_id']]);

        if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$p_name, $_SESSION['user_id']]);
        }

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$_SESSION['user_id'], $pid, $p_name, $p_price, $p_qty, $p_image]);
        $message[] = 'added to cart!';
    }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>Welcome To Techhy World</span>
         <br>
        <!-- <h3>"Transforming Dreams into Gadgets"</h3>-->
         <p>To Explore and Purchase the latest Technological Innovations</p>
         <a href="about.php" class="btn">About Us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">Shop By Category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/l2.jpg" alt="" height="260px" width="350px">
         <h3>Laptop</h3>
         <p>"In the World of Laptops, the possibilities are endless, and the only limit is your imagination." </p>
         <a href="category.php?category=Laptop" class="btn">Laptop</a>
      </div>

      <div class="box">
         <img src="images/s1.jpg" alt="" height="260px" width="350px">
         <h3>Desktop</h3>
         <p>"In a World of constant change, the Desktop computer remains a dependable companion."</p>
         <a href="category.php?category=Desktop" class="btn">Desktop</a>
      </div>

      <div class="box">
         <img src="images/m1.png" alt="" height="260px" width="350px">
         <h3>Smartphone</h3>
         <p> "Pocket-Sized Portal to the---------------------------------------------World!!."</p>
         <a href="category.php?category=Smartphone" class="btn">Smartphone</a>
      </div>

      <div class="box">
         <img src="images/k.jpg" alt="" height="260px" width="350px">
         <h3>Accessories</h3>
         <p>"These are the unsung heroes of our digital lives, enhancing our interactions with technology."</p>
         <a href="category.php?category=Accessories" class="btn">Accessories</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">Latest Arrivals</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">₹<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="" height="300px" width="300px">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      
      <!-- <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart"> -->
      <?php 
         if (!isset($user_id)) {
         }
         else{
      ?>
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <?php }?>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>