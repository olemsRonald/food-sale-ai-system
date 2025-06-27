<?php
session_start();

$conn = new mysqli("localhost", "root", "", "fsm_ai_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$phone = $_POST['phone'];
$password = $_POST['password'];

// Fetch user
$sql = "SELECT * FROM users WHERE phone='$phone'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: order.html");
        exit;
    } else {
        echo "Wrong password.";
    }
} else {
    echo "User not found.";
}

$conn->close();
?>