<?php
session_start();
include "config.php";

$stmt = $conn->prepare("SELECT COUNT(*) FROM client");//TO Check if the database has any records
$stmt->execute();
$stmt->bind_result($user_count);
$stmt->fetch();
$stmt->close();
?>

<h2>Register</h2>

<?php if ($user_count > 0)
    echo "<p style='color: blue;''><a href='login.php'> Log in here</a></p>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO client (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstname, $lastname, $username, $password);
?>