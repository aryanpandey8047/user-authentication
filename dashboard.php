<?php
session_start();
include "config.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

$stmt = $conn->prepare("SELECT * FROM client");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
<h3>Users List</h3>

<table border="1">
    <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row["username"]); ?></td>
            <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
            <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
            <td><?php echo htmlspecialchars($row["city"]); ?></td>
            <td><?php echo htmlspecialchars($row["email"]); ?></td>
            <td>
                <a href="dashboard.php?edit=<?php echo $row['username']; ?>">Edit</a> |
                <a href="dashboard.php?delete=<?php echo $row['username']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>