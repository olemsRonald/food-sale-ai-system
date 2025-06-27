<?php
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.html');
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "fsm_ai_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders
$orders = $conn->query("SELECT * FROM orders");

// Fetch users
$users = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - FSM-AI</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        table { margin-top: 20px; }
        h2 { margin-top: 50px; }
    </style>
</head>
<body>

<h1>Admin Dashboard - FSM-AI</h1>

<!-- Orders Table -->
<h2>User Orders</h2>
<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>User ID</th>
            <th>Budget</th>
            <th>Food Type</th>
            <th>Last Meal</th>
            <th>Suggested</th>
            <th>City</th>
            <th>Neighborhood</th>
            <th>Delivery</th>
            <th>Delivery Date</th>
            <th>Delivery Time</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($orders && $orders->num_rows > 0): ?>
            <?php while($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['budget']) ?></td>
                    <td><?= htmlspecialchars($row['food_type']) ?></td>
                    <td><?= htmlspecialchars($row['suggest']) ?></td>
                    <td><?= htmlspecialchars($row['city']) ?></td>
                    <td><?= htmlspecialchars($row['neighborhood']) ?></td>
                    <td><?= htmlspecialchars($row['delivery']) ?></td>
                    <td><?= htmlspecialchars($row['delivery_date']) ?></td>
                    <td><?= htmlspecialchars($row['delivery_time']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="10" class="text-center">No orders found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Users Table -->
<h2>Registered Users</h2>
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Health Status</th>
            <th>Age</th>
            <th>Sex</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($users && $users->num_rows > 0): ?>
            <?php while($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= htmlspecialchars($user['health']) ?></td>
                    <td><?= htmlspecialchars($user['age']) ?></td>
                    <td><?= htmlspecialchars($user['sex']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No users found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="logout.php" class="btn btn-danger">Logout</a>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>