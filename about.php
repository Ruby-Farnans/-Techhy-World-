<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
        <!-- <img src="images/obessum1.png" alt="">-->
         <h3>Why Choose Us?</h3>
         <p>We offer a vast selection of high-quality electronic products. Our user-friendly interface ensures hassle-free navigation and a secure shopping environment. With prompt customer support and convenient delivery options, we prioritize your satisfaction. Our commitment to quality and reliability, makes us the preferred destination for all your electronic needs.
          <br>"We're not just another option; We're the Best Choice."<br>"We Turn your Expectations into Experiences." </p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <!--<img src="images/obessum2.png" alt="">-->
         <h3>What We Provide?</h3>
         <p>At our electronic selling website, we provide a one-stop destination for all your tech needs. Explore our extensive range of products, including laptops, desktop computers, smartphones, and a wide array of electronic accessories. We offer top-notch, brand-name items, ensuring you have access to the latest technology and reliable options. Whether you're a professional seeking powerful computing solutions or a tech enthusiast looking for cutting-edge gadgets, we've got you covered. </p>
         <a href="shop.php" class="btn">our shop</a>
      </div>

   </div>

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>