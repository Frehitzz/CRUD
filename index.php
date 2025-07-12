<?php 
require_once("config_session.php"); //Add this for to keep the signup data
require_once("MVC_view_signup.php"); // Add this line
require_once("login_view.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>
<body>
    <div class="container">
        <div class="login">
            <form class="login-form" action="login.php" method="POST">
                <h1 class="title">Log in</h1>
                <?php
                display_login_err();
                ?>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input class="login-input" type="text" name="username" placeholder="Username">
                </div>

                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input id="login-pass" class="login-input" type="password" name="pass" placeholder="Password">
                    <i id="toggle-pass" class="fa-solid fa-eye" onclick="pass_manage()"></i>
                </div>

                <div class="login-options">
                    <a href="#" class="login-link" onclick="">Forgot Password?</a>
                    <a href="#" class="login-link" onclick="toggle_signup()">No account yet?</a>
                </div>
                <button class="login-button" type="submit">Log In</button>
            </form>
        </div>
        
        <div class="signup">
            <form class="signup-form" action="signup.php" method="POST">
                <h1 class="title">Create Account</h1>
                
                   
        
                <?php 
                display_signup_err();
                    // Keep user input
                    keep_input(); 
                ?>
                
                <div class="strength-indicator">
                    <div class="strength-bar" id="strengthBar"></div> <!--password bar-->
                </div>
                <input id="signup-pass-confirm" class="signup-input" type="password" name="con_pass" placeholder="Confirm Password"><br>
                <div class="checkb">
                    <input type="checkbox" onclick="passcheckb_manage()">
                    <label>Show Password</label>
                </div>
                <button class="signup-button" type="submit">Sign Up</button>
                <p class="title">Already have an account?<a class="signup-link" href="#" onclick="toggle_signup()"> Sign In</a></p>
            </form>
        </div>
    </div>
    
    <script src="js/script.js"></script>
    
    <?php
    // Clear the error messages after displaying them
    if (isset($_SESSION["errors_signup"])) {
        unset($_SESSION["errors_signup"]);
    }
    if (isset($_SESSION["data_signup"])) {
        unset($_SESSION["data_signup"]);
    }
    ?>
</body>
</html>