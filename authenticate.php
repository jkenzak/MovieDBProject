<?php
session_start(); // Ensure session is started at the beginning

if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Assuming $db is properly initialized in another included file
require 'db.php'; // Include your database connection file here

$query = "SELECT ReviewerID, `Password` FROM User WHERE Username = :username";
$statement = $db->prepare($query);
$statement->bindValue(':username', $_POST['username']);
$statement->execute();

if ($statement->rowCount() > 0) {
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if (password_verify($_POST['password'], $user['Password'])) {
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $user['ReviewerID'];
        header('Location: request-db.php'); 
        exit();
    } else {
      
        echo 'Incorrect username and/or password!';
    }
} else {
 
    echo 'Incorrect username and/or password!';
}

$statement->close();
?>
