<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin-login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

$id = $_GET["id"];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin-dashboard.php");
    exit;
} else {
    die("SQL error: " . $mysqli->error);
}
?>