<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>


  <section class="placed-orders">

    <h1 class="title">Placed Orders</h1>

    <div class="box-container">
      <?php
      if (isset($_GET["id"])) {
        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? AND id = ?");
        $select_orders->execute([$user_id, $_GET["id"]]);
        if ($select_orders->rowCount() > 0) {
          while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
            <div class="box">
              <p> Placed On : <span><?= $fetch_orders['placed_on']; ?></span> </p>
              <p> Name : <span><?= $fetch_orders['name']; ?></span> </p>
              <p> Number : <span><?= $fetch_orders['number']; ?></span> </p>
              <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
              <p> Address : <span><?= $fetch_orders['address']; ?></span> </p>
              <p> Payment Method : <span><?= $fetch_orders['method']; ?></span> </p>
              <p> Your Orders : <span><?= $fetch_orders['total_products']; ?></span> </p>
              <p> Total Price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
              <p> Payment Status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                        echo 'red';
                                                      } else {
                                                        echo 'green';
                                                      }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
            </div>
            <script>
              function onAfterPrint() {
                window.location.href = "./orders.php";
              }
              window.addEventListener("afterprint", onAfterPrint);
              window.print();
            </script>

          <?php
          }
        } else {
          echo '<p class="empty">no orders placed yet!</p>';
          ?>
          <script>
            alert("Inavalid Order to print");
            window.location.href = "./orders.php";
          </script>
      <?php
        }
      } else {
        header("Location: ./orders.php");
        exit();
      }
      ?>

    </div>

  </section>
  <script src="js/script.js"></script>

</body>

</html>