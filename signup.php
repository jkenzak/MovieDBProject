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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Upsorn Praphamontripong">
  <meta name="description" content="Maintenance request form, a small/toy web app for ISP homework assignment, used by CS 3250 (Software Testing)">
  <meta name="keywords" content="CS 3250, Upsorn, Praphamontripong, Software Testing">
  <link rel="icon" type="image/png" href="https://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="maintenance-system.css">  
</head>
<body>
<?php include("header.php"); ?>
<div class="w3-container w3-margin-top" style="max-width: 400px; margin: auto;">
    <h1 class="w3-center">MovieReviews</h1> 
    <h2 class="w3-center">Sign Up</h2>
    <?php if (!empty($message)): ?>
        <p class="w3-text-red w3-center"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="signup.php" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
        <div class="w3-row w3-section">
            <div class="w3-rest">
                <input class="w3-input w3-border" name="username" id="username" type="text" placeholder="Username" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-rest">
                <input class="w3-input w3-border" name="password" id="password" type="password" placeholder="Password" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Register</button>
    </form>
</div>
</body>
</html>
