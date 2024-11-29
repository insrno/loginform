<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin-login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

$result = $mysqli->query("SELECT * FROM users");

$users = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p><a href="logout.php">Log out</a></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user["id"]) ?></td>
                    <td><?= htmlspecialchars($user["fullname"]) ?></td>
                    <td><?= htmlspecialchars($user["email"]) ?></td>
                    <td>
                        <a href="edit-user.php?id=<?= $user["id"] ?>">Edit</a>
                        <a href="delete-user.php?id=<?= $user["id"] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>