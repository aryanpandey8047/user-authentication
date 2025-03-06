<?php
session_start();
include "config.php";

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

// Fetch all users from the database
$stmt = $conn->prepare("SELECT FROM users");
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

<!-- Display Users Table -->
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
            <td><?php echo htmlspecialchars($row["firstname"]); ?></td>
            <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
            <td><?php echo htmlspecialchars($row["city"]); ?></td>
            <td><?php echo htmlspecialchars($row["email"]); ?></td>
            <td>
                <a href="dashboard.php?edit=<?php echo $row['username']; ?>">Edit</a> |
                <a href="dashboard.php?delete=<?php echo $row['username']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Logout Button -->
<form method="POST">
    <button type="submit" name="logout">Logout</button>
</form>

<?php
// Logout functionality
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Handle delete user
if (isset($_GET["delete"])) {
    $deleteUser = $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM users WHERE username=?");
    $stmt->bind_param("s", $deleteUser);
    if ($stmt->execute()) {
        echo "<p style='color: red;'>User deleted successfully!</p>";
        header("Refresh:0; url=dashboard.php"); // Refresh the page
    } else {
        echo "<p style='color: red;'>Error deleting user.</p>";
    }
}

// Handle edit user
if (isset($_GET["edit"])) {
    $editUser = $_GET["edit"];
    $stmt = $conn->prepare("SELECT firstname, lastname FROM users WHERE username=?");
    $stmt->bind_param("s", $editUser);
    $stmt->execute();
    $stmt->bind_result($firstname, $lastname);
    $stmt->fetch();
    $stmt->close();
?>

<!-- Edit User Form -->
<h3>Edit User: <?php echo htmlspecialchars($editUser); ?></h3>
<form method="POST">
    <input type="hidden" name="edit_username" value="<?php echo htmlspecialchars($editUser); ?>">
    <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required><br>
    <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required><br>
    <button type="submit" name="update">Update</button>
</form>

<?php
}

// Handle update user
if (isset($_POST["update"])) {
    $editUsername = $_POST["edit_username"];
    $newFirstname = $_POST["firstname"];
    $newLastname = $_POST["lastname"];

    $stmt = $conn->prepare("UPDATE users SET firstname=?, lastname=? WHERE username=?");
    $stmt->bind_param("sss", $newFirstname, $newLastname, $editUsername);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>User updated successfully!</p>";
        header("Refresh:0; url=dashboard.php"); // Refresh the page
    } else {
        echo "<p style='color: red;'>Error updating user.</p>";
    }
}
?>

</body>
</html>
