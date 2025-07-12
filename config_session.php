<?php
// prevents hackers from putting session IDs in the website URL.
ini_set('session.use_only_cookies',1);
//Only accept session IDs that the server created (not fake ones from hackers).
ini_set('session.use_strict_mode',1);

    session_set_cookie_params([ // to change or edit the cookie
        'lifetime' => 1800,     //cookie expires after 30minutes, 1800 is seconds
        'domain' => 'localhost',//Only works on localhost
        'path' => '/',          //Works on entire website
        'secure' => true,       //only send over HTTPS (encrypted)
        'httponly' =>true       //JavaScript can't access this cookie
    ]);

    session_start(); // Give me my ID card or create a new one

    /*-----------The Main Logic - ID Card Renewal:-------------*/

    // If someone is logged in...
    if(isset($_SESSION["user_id"])){ 
        // If this is their first time, give them a new special ID card
        if(!isset($_SESSION["last_regeneration"])){
        regenerate_session_id_loggedin();
    }else{
        // If their ID card is older than 30 minutes, give them a new one
        $deadline = 60 * 30; //60-seconds 30-minute
        if(time() - $_SESSION["last_regeneration"] >= $deadline){
            regenerate_session_id_loggedin();
        } 
    }
    }else{
        //If they're just browsing (not logged in), still renew their basic ID card every 30 minutes
        if(!isset($_SESSION["last_regeneration"])){
        regenerate_session();
        }else{
        $deadline = 60 * 30; //60-seconds 30-minute
        if(time() - $_SESSION["last_regeneration"] >= $deadline){
            regenerate_session();
        } 
    }
    }

    /*--------For Logged-in Users:----------*/

    // Create a special ID card that includes the user's ID number
    function regenerate_session_id_loggedin(){
        session_regenerate_id(true); // Destroy old id, Create a new one

            $userId = $_SESSION["user_id"]; // Get users id
            $newSessionId = session_create_id(); //  Create new session id
            $sessionId = $newSessionId . "_" . $userId; // combine them
            session_id($sessionId);      // set the new combine id

        $_SESSION["last_regeneration"] = time(); //remember when we did this
    }

    /*-----------For guest users-----------*/

    //Create a basic ID card for visitors
    function regenerate_session(){
        session_regenerate_id(true); // Create basic id
        $_SESSION["last_regeneration"] = time(); // remember when we did this
    }
?>