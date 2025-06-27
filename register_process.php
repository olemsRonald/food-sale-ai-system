<?php
// Start session
session_start();

// Connect to your database
$conn = new mysqli("localhost", "root", "", "fsm_ai_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize inputs
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$health = trim($_POST['health']);
$age = intval($_POST['age']);
$sex = trim($_POST['sex']);
$password = trim($_POST['password']); // Password in plain text (not hashed)

// Optional: Check if phone number already exists
$check = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$check->bind_param("s", $phone);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('Phone number already registered. Please login.'); window.location.href='login.html';</script>";
    $check->close();
    $conn->close();
    exit();
}
$check->close();

// Insert user into the database
$stmt = $conn->prepare("INSERT INTO users (name, phone, health, age, sex, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $name, $phone, $health, $age, $sex, $password);

if ($stmt->execute()) {
    // Set session and redirect to order page
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['name'] = $name;
    header("Location: order.html");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>