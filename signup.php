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
        if(username_registered($pdo,$email)){
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
        if(password_too_weak($password)){
            $errors["weak-password"] = "The password is weak";
        }

        




    }catch(PDOException $e){
        die("COnnection Failed: ". $e->getMessage());
    }
}else{
    header("Location: index.php");
    die();
}
?>