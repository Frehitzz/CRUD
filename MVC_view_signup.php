<?php
declare(strict_types=1);

function keep_input(){
    //CHECK IF "[THERES A SESSION CALLED DATA_SIGNUP]" and if the user fill the "[username input fields]"
    if(isset($_SESSION["data_signup"]["username"])
    // AND is NOT have an error on [session for error] and the error name is [username-taken]
    // "username-taken is the error key on username_registered function"
    && !isset($_SESSION["errors_signup"]["username-taken"]))
    {

        //  IF THE USER FILL THE USERNAME INPUT FIELD AND NO ERROR THEN RUN THIS CODE:

        // get the input field for username on out index or html\
        // added a value where inside is the session for data signup and the user that fill the username field
       echo '<input class="signup-input" type="text" name="username" placeholder="Username"
            value=" '.$_SESSION["data_signup"]["username"].' "><br>';
    }else{
        // IF THE USER DID NOT TYPE ON USERNAME FIELD AND HAVE AN ERROR THEN RUN THIS CODE:
        //get the input fieldd on our html and dont change anything
        echo '<input class="signup-input" type="text" name="username" placeholder="Username"><br>';
    }

    // SAME AS THE TOP
    if(isset($_SESSION["data_signup"]["email"])
    //WE have two error handling for the email put it
    && !isset($_SESSION["errors_signup"]["invalid-email"])
    && !isset($_SESSION["errors_signup"]["email-taken"]))
    {
        echo '<input class="signup-input" type="email" name="email" placeholder="Email"
            value=" ' .$_SESSION["data_signup"]["email"]. ' "><br>';
    }else{
        echo '<input class="signup-input" type="email" name="email" placeholder="Email"><br>';
    }

    //Outsife of the if-else statement put the password field here
    //make sure na yung pagkakasunod sunod the mga input field ay same sa html form mo
    echo '<input id="signup-pass" class="signup-input" type="password" name="pass" placeholder="Password" oninput="pass_strength(this.value)">';

    if(!isset($_SESSION["errors_signup"])){
        unset($_SESSION["data_signup"]);
    }



}


?>