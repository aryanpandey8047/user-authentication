<?php
session_start();
include "config.php";
$recordExists = false;
$result = $conn->query("SELECT COUNT(*) as count FROM client");
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    $recordExists = true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("INSERT INTO client (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");//creating records
    $stmt->bind_param("ssss", $firstname, $lastname, $username, $password);

    if ($stmt->execute()) 
    {
        echo "<p style='color:green;'>Registration successful! </p>";
    } 
    else 
    {
        echo "<p style='color:red;'>Error: Could not register user.</p>";
    }
    $stmt = $conn->prepare("SELECT COUNT(*) FROM client");//TO Check if the database has any records inorder to hide login if no record is present in the table
    $stmt->execute();
    $stmt->bind_result($user_count);
    $stmt->fetch();
    $stmt->close();

    if ($user_count > 0)
    echo "<p style='color: blue;''><a href='login.php'> Log in here</a></p>";
}
?>

<h2>Register</h2>

<form method="POST">
    <input type="text" name="firstname" placeholder="First name" required><br>
    <input type="text" name="lastname" placeholder="Last name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>