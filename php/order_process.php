<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fsm_ai_db");

if (!isset($_SESSION['user_id'])) {
    echo "Please login to place an order.";
    exit;
}

$user_id = $_SESSION['user_id'];
$budget = $_POST['budget'];
$food_type = $_POST['food_type'];
$last_meals = $_POST['last_meals'];
$suggest = $_POST['suggest'];
$city = $_POST['city'];
$neighborhood = $_POST['neighborhood'];
$delivery = $_POST['delivery'];
$date = $_POST['delivery_date'];
$time = $_POST['delivery_time'];

$sql = "INSERT INTO orders 
(user_id, budget, food_type, last_meals, suggest, city, neighborhood, delivery, delivery_date, delivery_time)
VALUES 
('$user_id', '$budget', '$food_type', '$last_meals', '$suggest', '$city', '$neighborhood', '$delivery', '$date', '$time')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully! <a href='index.html'>Return to Home</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>