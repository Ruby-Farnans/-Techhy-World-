<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
};

if (isset($_POST['order'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = 'razorpay';
   $address = 'flat no. ' . $_POST['flat'] . ' ' . $_POST['street'] . ' ' . $_POST['city'] . ' ' . $_POST['state'] . ' ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if ($cart_query->rowCount() > 0) {
      while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
         $cart_products[] = $cart_item['name'] . ' ( ' . $cart_item['quantity'] . ' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if ($cart_total == 0) {
      $message[] = 'your cart is empty';
   } elseif ($order_query->rowCount() > 0) {
      $message[] = 'order placed already!';
   } else {
      $status = "success";
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on, $status]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
   }
}


?>

<?php
if (isset($_POST['totalprice'])) {
   $totalprice = $_POST['totalprice'];
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form action="successpage.php" method="POST">
   <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="" data-amount="<?php echo $totalprice * 100 ?>" data-currency="INR" data-id="<?php echo 'OID' . rand(10, 1000) . 'END' ?>" data-buttontext="Pay with Razorpay" data-name="MCA " data-description="Electronic Shopping" // data-image="https://sawantinfotech.in/assets/logo.png" data-prefill.name="<?php echo $_POST['name']; ?>" data-prefill.email="<?php echo $_POST['email']; ?>" data-prefill.contact="<?php echo $_POST['number']; ?>" data-theme.color="#fc7703">
   </script>
   <input type="hidden" custom="Hidden Element" name="hidden" />
</form>


<style>
   .razorpay-payment-button {
      display: none;
   }
</style>

<script type="text/javascript">
   $(document).ready(function() {
      $('.razorpay-payment-button').click();
   });
</script>