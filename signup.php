<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confirmpass = $_POST["con_pass"];

    try{
        require_once("database.php");
        require_once("MVC_control_signup.php");
        require_once("MVC_model_signup.php");
        require_once("MVC_view_signup.php");


        $errors = []; // ARRAY FOR STORING ERROR MESSAGE


        // HANDLING ERRORL LOGIC

        //Check if the there are empty field
        if(empty_field($username,$email,$pass,$confirmpass)){
            $errors["empty-input"] = "Please Fill all the Fields";
        }

        //CHECK IF THE EMAIL IS INVALID
        if(!empty($email) && invalid_email($email)){
            $errors["invalid-email"] = "Invalid Email";
        }

        //CHECK IF THE USERNAME IS ALREADY REGISTERED
        if(username_registered($pdo,$username)){
            $errors["username-taken"] = "The username is already taken";
        }

        //CHECK IF THE EMAIL IS ALREADY REGISTERED
        if(email_registered($pdo,$email)){
            $errors["email-taken"] = "The email is already taken";
        }

        //CHECK IF THE PASS AND CONFIRMPASS IS MATCH
        //the symbol !== is for "not equal"
        if($pass !== $confirmpass){
            $errors["pass-not-match"] = "The password is not match";
        }

        //CHECK IF THE PASSWROD STRENGTH IS MET
        if(!empty($pass) && password_too_weak($pass)){
            $errors["weak-password"] = "The password is weak";
        }

        // DISPLAY ERR MESSAGE AND KEEP THE USERS INPUT
        require_once("config_session.php"); // Start the session and set cookie options
        if ($errors) {
        $_SESSION["errors_signup"] = $errors;
        // Optionally keep input data
        $_SESSION["data_signup"] = [
            "username" => $username,
            "email" => $email
        ];
        header("Location: index.php?show=signup"); //show=signup is for showing the signupform
        exit();
        }

        //Putting the signup info on database
        create_user($pdo,$username,$email,$pass);

        //Create a session of username that the user put
        //this will display on home.php
        $_SESSION['user_username'] = $username;
        
        //after signing up it will redirecxt to home.php
        header("Location: home.php");
        $pdo = null;
        die();

        

    }catch(PDOException $e){
        die("COnnection Failed: ". $e->getMessage());
    }
}else{
    header("Location: index.php");
    die();
}
?>