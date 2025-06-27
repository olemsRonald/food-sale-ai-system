<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $budget = $_POST['budget'];
    $food_type = $_POST['food_type'];
    $last_meal = $_POST['last_meal'];
    $health = $_POST['health'];
    $city = $_POST['city'];
    $neighborhood = $_POST['neighborhood'];
    $delivery = $_POST['delivery'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_time = $_POST['delivery_time'];

    // AI-like food suggestion based on health condition
    $suggest = "Balanced meal";
    $health_lower = strtolower($health);

    if (strpos($health_lower, 'diabet') !== false) {
        $suggest = "Low sugar food like Ndolé without fufu, grilled fish with vegetables";
    } elseif (strpos($health_lower, 'hypertens') !== false || strpos($health_lower, 'pressure') !== false) {
        $suggest = "Low salt food like boiled plantains, koki beans, or okra soup";
    } elseif (strpos($health_lower, 'ulcer') !== false) {
        $suggest = "Soft foods like ripe plantains, boiled rice with ripe banana and no pepper";
    } elseif (strpos($health_lower, 'malaria') !== false || strpos($health_lower, 'fever') !== false) {
        $suggest = "Liquid and energy foods like pepper soup, corn chaff, or achu without red oil";
    }

    // Insert into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, budget, food_type, last_meal, suggest, city, neighborhood, delivery, delivery_date, delivery_time)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $user_id, $budget, $food_type, $last_meal, $suggest, $city, $neighborhood, $delivery, $delivery_date, $delivery_time);

    if ($stmt->execute()) {
        // Show result to user
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Order Confirmation</title>
            <link rel='stylesheet' href='css/bootstrap.min.css'>
            <style>
                body { padding: 50px; font-family: Arial, sans-serif; }
                .box { max-width: 600px; margin: auto; padding: 30px; border-radius: 10px; background: #f8f9fa; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                .suggest { font-weight: bold; color: green; }
            </style>
        </head>
        <body>
            <div class='box'>
                <h2 class='text-center'>✅ Order Placed Successfully!</h2>
                <p>Thank you for placing your order.</p>
                <p class='suggest'>🍽 Based on your health condition, we suggest: <br><u>$suggest</u></p>
                <div class='text-center mt-4'>
                    <a href='logout.php' class='btn btn-danger'>Logout</a>
                    <a href='order.html' class='btn btn-secondary ml-2'>Order Again</a>
                </div>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "❌ Failed to place your order. Please try again.";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: order.html");
    exit();
}
?>