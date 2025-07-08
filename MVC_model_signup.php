<?php

// we have an object $pdo we need this for the connection of the datababse
function username_taken(object $pdo, string $username){
    /*
    username = is the name of the column in our mysql.
    users = name if the table.
    :username = is just an placeholder or named parameter.
    */
    $query = "SELECT username FROM users WHERE username = :username;"; 
    $stmt = $pdo->prepare($query); // $pdo will use a tool called prepare()

    // bindParam is to replaced the placeholder to the variable of usernme
    $stmt->bindParam(":username", $username); 
    $stmt->execute(); // change now or display this to mysql

    /*
    fetch() - it gets only the one row of results
    PDO::FETCH_ASSOC - return the data as an array with column name as keys, example:
    ["username"=> "fritz"] 
    */
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // to display the result whoever called this function
    return $result;
}

?>