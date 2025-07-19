<?php 
require_once("config_session.php"); //Add this for to keep the signup data
require_once("MVC_view_signup.php"); // Add this line
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1> Welcome <?php echo htmlspecialchars($_SESSION['user_username']);?></h1>
</body>
</html>