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
?>