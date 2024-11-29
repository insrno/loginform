<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM admins WHERE username = '%s'", $mysqli->real_escape_string($_POST["username"]));

    $result = $mysqli->query($sql);
    $admin = $result->fetch_assoc();

    if ($admin) {
        if (password_verify($_POST["password"], $admin["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["admin_id"] = $admin["id"];
            header("Location: admin-dashboard.php");
            exit;
        }
    }
    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Admin Login</h1>
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    <form id="admin-login" method="post" novalidate>
        <div>
            <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <button>Login</button>
    </form>
    <p><a href="admin-signup.php">Create Admin Account</a></p>
</body>
</html>