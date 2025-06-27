<?php
session_start();

$suggest = isset($_SESSION['suggest']) ? $_SESSION['suggest'] : "No suggestion available.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmed - FSM-AI</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    body {
      padding: 50px;
      background-color: #f4f4f4;
    }
    .confirmation-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
  </style>
</head>
<body>
  <div class="container text-center confirmation-box">
    <h2>✅ Order Placed Successfully!</h2>
    <p class="mt-3">Thank you for your order. Our system has selected a recommended dish based on your health status:</p>
    
    <h4 class="text-success mt-4">🍲 Suggested Dish: <?php echo htmlspecialchars($suggest); ?></h4>

    <a href="logout.php" class="btn btn-danger mt-4">Logout</a>
  </div>
</body>
</html>