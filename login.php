<form method="POST">
    <input type="text" name="username" placeholder="username" required><br>
    <input type="password" name="password" placeholder="password" required><br>
    <button type="submit">Login</button>
</form>

<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM client WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        if ($password === $stored_password) { 
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit;  
        } else {
            echo "<p style='color:red;'>Incorrect password!</p>";
        }
    } else {
        echo "<p style='color:red;'>Username not found!</p>";
    }

    $stmt->close();
}
?>