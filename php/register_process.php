<?php
// Connect to your database
$conn = new mysqli("localhost", "root", "", "fsm_ai_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive form values
$name = $_POST['name'];
$phone = $_POST['phone'];
$health = $_POST['health'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashed password

// Check if phone already exists
$check = $conn->query("SELECT * FROM users WHERE phone='$phone'");
if ($check->num_rows > 0) {
    echo "Phone number already exists. Try logging in.";
    exit;
}

// Insert user into database
$sql = "INSERT INTO users (name, phone, health, age, sex, password)
        VALUES ('$name', '$phone', '$health', '$age', '$sex', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful. <a href='login.html'>Login Now</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>