<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $pass = $_POST["pass"];

    try{
        require_once("database.php");
        require_once("login_control.php");
        require_once("login_model.php");
        require_once("login_view.php");
    
    // store the signup info on the result variable on our login
    $result = get_user($pdo, $username);
    
    $errors = [];

    if(empty_field($username, $pass)){
        $errors["empty-field"] = "Please fill all the fields";
    }elseif(is_username_wrong($result)){
        $errors["email-wrong"] = "The Username is incorrect";
    }elseif(is_pass_wrong($pass, $result["pass"])){
         $errors["pass-wrong"] = "The password is incorrect";
    }

    require_once("config_session.php");

    //Check if there are error 
    if($errors){
        //if there are error create a session
        $_SESSION["errors_login"] = $errors;

        header("Location: index.php");
        die();
    }

    //GENERATING A NEW ID SESSION WHEN THERE ARE CHANGES 

    //This generates a unique identifier that's impossible to guess.
    $newSessionId = session_create_id();
    /*
     - Combine the random ID with the user's database ID
     - If the random ID is abc123 and user's database ID is 45, 
     the final session ID becomes abc123_45
     */
    $sessionId = $newSessionId . "_" . $result["id"];
    //This tells PHP to use this specific ID for this user's session.
    session_id($sessionId);

    $_SESSION["user_id"] = $result["id"]; // Remember this user's ID number

    /*
    - Remember this user's username, but make it safe
    - htmlspecialchars() does: Converts dangerous characters 
    like < and > into safe versions so hackers can't inject malicious code.
    */
    $_SESSION["user_username"] = htmlspecialchars($result["username"]);

    //Remember when we created this session
    $_SESSION["last_regeneration"] = time();

    header("Location: home.php");
    die();
        
    }catch(PDOException $e){
        die("Query Failed:". $e->getMessage());
    }


}else{
    header("Location: index.php");
    die();

}

?>