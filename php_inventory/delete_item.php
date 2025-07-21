<?php
require_once("../database.php");

if(isset($_GET['id'])){
    $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->execute([$_GET['id']]);

}

header("Location: ../home.php");
exit;

?>