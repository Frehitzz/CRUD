<?php
declare(strict_types=1); // to declare the data types on the function

//EMPTY FIELD LOGIC
function empty_field(string $username,string $email,string $pass,string $confirmpass){
    //CHECKING IF ITS EMPTY
    if(empty($username)||empty($email)||empty($pass)||empty($confirmpass)){
        return true;
    }else{
        return false;
    }
}

function invalid_email(string $email){
    /*
    1.filter_var is a php built in function it validate and sanitize data.
    2.FILTER_VALIDATE_EMAIL Check if a string is a valid email address 
    using standard email formatting rules.

    Theres a "!" its to return the error mess aas true
    */
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function username_registered(object $pdo,string $username){
    //username_taken is the function that created on model.php file
    if(username_taken($pdo,$username)){
        return true;
    }else{
        return false;
    }
}

function email_registered(object $pdo, string $email){
    if(email_taken($pdo,$email)){
        return true;
    }else{
        return false;
    }
}

function password_too_weak(string $password){
    $strength = 0; // storing the strtength points here

    //Checks if the password have 8 or more char
    if(strlen($password) >= 8) $strength++;

    //preg_match = checks if something exist like this in string 
    if(preg_match('/[a-z]/', $password)) $strength++;
    if(preg_match('/[A-Z]/', $password)) $strength++;
    if(preg_match('/[0-9]/', $password)) $strength++;
    if(preg_match('/[^a-zA-Z0-9]/', $password)) $strength++;

    return $strength < 4; // Less than 4 is considered weak
}

function create_user(object $pdo, string $username, string $email, string $pass){
    set_user($pdo,$username,$email,$pass);
}

?>