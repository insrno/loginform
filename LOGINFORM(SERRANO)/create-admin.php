<?php
$mysqli = require __DIR__ . "/database.php";

$username = 'admin';
$password_hash = password_hash('adminpassword', PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (username, password_hash) VALUES (?, ?)";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ss", $username, $password_hash);

if ($stmt->execute()) {
    echo "Admin account created successfully.";
} else {
    die("SQL error: " . $mysqli->error);
}
?>