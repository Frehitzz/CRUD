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
        if(invalid_email($email)){
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
        if(password_too_weak($pass)){
            $errors["weak-password"] = "The password is weak";
        }

        // DISPLAY ERR MESSAGE AND KEEP THE USERS INPUT
        require_once("config_session.php"); // Start the session and set cookie options
        if($errors){ //check if theres error in signing up
            //store the error mess in a seesion so we can display them later
            $_SESSION["errors_signup"] = $errors;
            //Store the users input when there are error only username and email will store
            $signupdata = [
                "username" => $username, //kepp the entered username
                "email" => $email // keep the entered email
            ];
            
            //save the user's input in a session to pre fill the form
            $_SESSION["data_signup"] = $signupdata;
            // Redirect the user back to the signup form page
            header("Location: index.php");
            die(); // stop the script execution after redirect to the header
        }
        




    }catch(PDOException $e){
        die("COnnection Failed: ". $e->getMessage());
    }
}else{
    header("Location: index.php");
    die();
}
?>