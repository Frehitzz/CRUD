<?php
declare(strict_types=1);

function empty_field(string $username,string $email,string $pass,string $confirmpass){
    if(empty($username)||empty($email)||empty($pass)||empty($confirmpass)){
        return true;
    }else{
        return false;
    }
}

?>