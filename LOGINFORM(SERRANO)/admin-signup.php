<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    if (empty($username)) {
        $errors[] = "Username is required!";
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

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (username, password_hash) VALUES (?, ?)";
        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            $errors[] = "SQL error: " . $mysqli->error;
        } else {
            $stmt->bind_param("ss", $username, $password_hash);

            if ($stmt->execute()) {
                header("Location: admin-login.php");
                exit;
            } else {
                if ($mysqli->errno === 1062) {
                    $errors[] = "Username already taken";
                } else {
                    $errors[] = $mysqli->error . " " . $mysqli->errno;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Admin Signup</h1>
    <?php if (!empty($errors)): ?>
        <em><?= htmlspecialchars(implode(", ", $errors)) ?></em>
    <?php endif; ?>
    <form id="admin-signup" method="post" novalidate>
        <div>
            <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <div>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
        </div>
        <button>Signup</button>
    </form>
</body>
</html>