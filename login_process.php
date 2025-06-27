<?php
session_start();

// Connexion
$conn = new mysqli("localhost", "root", "", "fsm_ai_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Vérifier si c'est un admin
    if ($phone === "admin" && $password === "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit();
    }

    // Sinon, vérifier si utilisateur existe
    $stmt = $conn->prepare("SELECT id, name FROM users WHERE phone = ? AND password = ?");
    $stmt->bind_param("ss", $phone, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name);
        $stmt->fetch();

        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;

        header("Location: order.html");
        exit();
    } else {
        echo "<script>alert('Invalid phone or password.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>