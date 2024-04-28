<?php
require("connect-db.php");  // Include your DB connection settings
require("request-db.php");  // Include your DB functions, make sure this includes the loginUser function

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        header("Location: request.php"); 
        exit;
    } else {
        $message = "Login failed. Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Movie Reviews</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-container w3-margin-top">
    <h2>Login</h2>
    <?php if (!empty($message)): ?>
        <p class="w3-text-red"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required class="w3-input w3-border">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required class="w3-input w3-border">
        <button type="submit" name="login" class="w3-btn w3-blue w3-margin-top">Login</button>
    </form>
</div>
</body>
</html>
