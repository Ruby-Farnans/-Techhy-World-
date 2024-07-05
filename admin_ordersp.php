<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){

   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'Payment has been updated!';

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

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
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      /* Style the table and its elements */
      .order-table {
         width: 100%;
         border-collapse: collapse;
         margin: 20px 0;
      }

      .order-table th, .order-table td {
         border: 1px solid #ddd;
         padding: 10px;
         text-align: center;
      }

      .order-table th {
         background-color: #f2f2f2;
         font-weight: bold;
         font-size: 15px;
      }

      .order-table tr:nth-child(even) {
         background-color: #f2f2f2;
      }
      td{
         font-size: 15px;
      }

      /* Style the action buttons and dropdowns */
      .drop-down {
         width: 100%;
         padding: 8px;
      }

      .option-btn {
         background-color: #4CAF50;
         color: white;
         padding: 6px 8px; 
         font-size: 12px;
         border: none;
         cursor: pointer;
      }

      .delete-btn {
         background-color: #f44336;
         color: white;
         padding: 6px 8px; /* Reduced padding for a smaller button */
         font-size: 12px; /* Reduced font size for the button text */
         border: none;
         cursor: pointer;
         text-decoration: none;
         
      }

      .delete-btn:hover {
         background-color: #d32f2f;
      }

      /* Style the "No orders placed yet!" message */
      .empty {
         text-align: center;
         font-weight: bold;
         color: #777;
      }
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">
   <h1 class="title">Placed Orders</h1>

   <table class="order-table">
      <thead>
         <tr>
            <th>User ID</th>
            <th>Placed On</th>
            <th>Name</th>
            <th>Email</th>
            <th>Number</th>
            <th>Address</th>
            <th>Total Products</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders` where payment_status='pending'");
            $select_orders->execute();
            if($select_orders->rowCount() > 0){
               while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
         ?>
         <tr>
            <td><?= $fetch_orders['user_id']; ?></td>
            <td><?= $fetch_orders['placed_on']; ?></td>
            <td><?= $fetch_orders['name']; ?></td>
            <td><?= $fetch_orders['email']; ?></td>
            <td><?= $fetch_orders['number']; ?></td>
            <td><?= $fetch_orders['address']; ?></td>
            <td><?= $fetch_orders['total_products']; ?></td>
            <td>₹<?= $fetch_orders['total_price']; ?>/-</td>
            <td><?= $fetch_orders['method']; ?></td>
            <td style="width: 120px;>
               <form action="" method="POST">
                  <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                  <select name="update_payment" class="drop-down">
                     <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                     <option value="pending">Pending</option>
                     <option value="Success">Success</option>
                  </select>
                  <input type="submit" name="update_order" class="option-btn" value="Update">
               </form>
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
            </td>
         </tr>
         <?php
            }
         } else {
            echo '<tr><td colspan="10" class="empty">No orders placed yet!</td></tr>';
         }
         ?>
      </tbody>
   </table>
</section>

<script src="js/script.js"></script>
</body>
</html>
