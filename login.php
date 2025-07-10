<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $pass = $_POST["pass"];

    try{
        require_once("database.php");
        require_once("login_control.php");
        require_once("login_model.php");
        require_once("login_view.php");



        
    }catch(PDOException $e){
        die("Query Failed:". $e->getMessage());
    }


}else{
    header("Location: index.php");
    die();

}

?>