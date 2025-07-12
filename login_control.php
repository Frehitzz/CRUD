<?php
declare(strict_types=1);

//Check if the field is empty
function empty_field(string $username, string $pass){
    if(empty($username)||empty($pass)){
        return true;
    }else{
        return false;
    }
}

//Check if the username is on the database
function is_username_wrong(bool|array $result){
    // When PDO fetch() finds no matching records, it returns false
    // When it finds a user, it returns an array with user data
    if(!$result){
        return true;  // No user found - username is wrong
    }else{
        return false; // User found - username exists
    }
}

function is_pass_wrong(string $pass, string $hashpass){
    //used to verify if a plain text password matches a hashed password
    if(!password_verify($pass, $hashpass)){ 
        return true;
    }else{
        return false;
    }
}


?>