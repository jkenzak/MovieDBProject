<?php
require("connect-db.php");
require("request-db.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (registerUser($username, $password)) {
        $message = "Registration successful! You can now login.";
    } else {
        $message = "Username is already taken";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign Up - Movie Reviews</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-container w3-margin-top">
    <h2>Sign Up</h2>
    <?php if (!empty($message)): ?>
        <p class="w3-text-red"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="signup.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required class="w3-input w3-border">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required class="w3-input w3-border">
        <button type="submit" name="register" class="w3-btn w3-blue w3-margin-top">Register</button>
    </form>
</div>
</body>
</html>
