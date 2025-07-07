<?php
$db_server = "localhost"; //host
$db_user = "root";
$db_pass = "";
$db_name = "crud";

try{

$pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

}catch(PDOException $e){
    die("Connection Failed: " . $e->getMessage());
}
?>