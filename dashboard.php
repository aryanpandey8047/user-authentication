<?php
session_start();
include "config.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

$stmt = $conn->prepare("SELECT first_name, last_name FROM client WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($first_name, $last_name);
$stmt->fetch();
$stmt->close();

if (isset($_POST["update"])) {
    $new_firstname = trim($_POST['firstname']);
    $new_lastname = trim($_POST['lastname']);
    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['password']);

    if (!empty($new_password)) {
        $stmt = $conn->prepare("UPDATE client SET first_name=?, last_name=?, username=?, password=? WHERE username=?");
        $stmt->bind_param("sssss", $new_firstname, $new_lastname, $new_username, $new_password, $username);
    } else {
        $stmt = $conn->prepare("UPDATE client SET first_name=?, last_name=?, username=? WHERE username=?");
        $stmt->bind_param("ssss", $new_firstname, $new_lastname, $new_username, $username);
    }
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Profile updated successfully!</p>";

        $_SESSION["username"] = $new_username;
        $username = $new_username;
        $first_name = $new_firstname;
        $last_name = $new_lastname;
    } else {
        echo "<p style='color:red;'>Error updating profile!</p>";
    }
}

if (isset($_POST["delete"])) {
    $stmt = $conn->prepare("DELETE FROM client WHERE username=?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            session_unset();
            session_destroy();
            header("Location: register.php");
            exit;
        } else {
            echo "<p style='color:red;'>Error: No records were deleted.</p>";
        }
    } else {
        echo "<p style='color:red;'>Error deleting account!</p>";
    }
}
?>

<h2>Welcome, <?php echo htmlspecialchars($first_name . " " . $last_name); ?>!</h2>
<p>Username: <?php echo htmlspecialchars($username); ?></p>

<h3>Edit Profile</h3>
<form method="POST">
    <input type="text" name="firstname" value="<?php echo htmlspecialchars($first_name); ?>" required><br>
    <input type="text" name="lastname" value="<?php echo htmlspecialchars($last_name); ?>" required><br>
    <input type="text" name="new_username" value="<?php echo htmlspecialchars($username); ?>" required><br>
    <input type="password" name="password" placeholder="New Password (optional)"><br>
    <button type="submit" name="update">Update Profile</button>
</form>

<h3>Delete Account</h3>
<form method="POST">
    <button type="submit" name="delete" onclick="return confirm('Are you sure? This action is irreversible.');">Delete My Account</button>
</form>

<a href="logout.php">Logout</a>