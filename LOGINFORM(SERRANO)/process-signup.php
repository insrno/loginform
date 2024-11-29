<?php

function redirect_with_errors($errors, $name, $email) {
    $error_string = implode(", ", $errors);
    header("Location: signup.php?error=" . urlencode($error_string) . "&name=" . urlencode($name) . "&email=" . urlencode($email));
    exit;
}

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm-password"];

$errors = [];

if (empty($name)) {
    $errors[] = "Name is required!";
}

if (empty($email)) {
    $errors[] = "Email is required!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid Email is required";
}

if (empty($password)) {
    $errors[] = "Password is required!";
} elseif (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
} elseif (!preg_match("/[a-z]/i", $password)) {
    $errors[] = "Password must contain at least one letter";
} elseif (!preg_match("/[0-9]/i", $password)) {
    $errors[] = "Password must contain at least one number";
}

if (empty($confirm_password)) {
    $errors[] = "Confirm Password is required!";
} elseif ($password !== $confirm_password) {
    $errors[] = "Passwords must match";
}

if (!empty($errors)) {
    redirect_with_errors($errors, $name, $email);
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    $errors[] = "SQL error: " . $mysqli->error;
    redirect_with_errors($errors, $name, $email);
}

$stmt->bind_param("sss", $name, $email, $password_hash);

if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        $errors[] = "Email already taken";
    } else {
        $errors[] = $mysqli->error . " " . $mysqli->errno;
    }
    redirect_with_errors($errors, $name, $email);
}
?>