<?php
// Check if the payment was successful (You should implement your payment logic here)
$paymentSuccessful = true;

if ($paymentSuccessful) {
    // Payment successful, proceed to display the success page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #008000; /* Green color for success */
        }
        p {
            font-size: 18px;
        }
        .plant-image {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful</h1>
        <p>Thank you for your payment. Your order has been successfully processed.</p>
        <!-- <img class="plant-image" src="./images/arrb.jpg" alt="Plant Photo"> -->
        
        <a href="home.php">Go To Home</a>
        <!-- You can include more plant photos here -->
    </div>
</body>
</html>

<?php
} else {
    // Payment failed, display an error message or redirect to a failure page
    echo "Payment failed. Please try again.";
}
?>
