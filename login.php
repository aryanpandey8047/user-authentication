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
