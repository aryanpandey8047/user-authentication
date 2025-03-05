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