<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="js/validation.js" defer></script>
</head>
<body>
    <h1>Signup</h1>
    <form id="signup" action="process-signup.php" method="post" novalidate>
        <div>
            <input type="text" id="name" name="name" placeholder="Fullname">
        </div>
        <div>
            <input type="email" id="email" name="email" placeholder="Email Address">
        </div>
        <div style="position: relative;">
            <input type="password" id="password" name="password" placeholder="Password" >
            <span onclick="togglePassword('password', this)" 
                  style="position: absolute; right: 610px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                👁️
            </span>
        </div>
        <div style="position: relative;">
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
            <span onclick="togglePassword('confirm-password', this)" 
                  style="position: absolute; right: 610px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                👁️
            </span>
        </div>
        <button>Signup</button>
    </form>

    <script>
        function togglePassword(fieldId, iconElement) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text"; // Show password
                iconElement.textContent = "🙈"; // Change icon to "hide" symbol
            } else {
                field.type = "password"; // Hide password
                iconElement.textContent = "👁️"; // Change back to "show" symbol
            }
        }
    </script>
</body>
</html>