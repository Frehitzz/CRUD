<?php
declare(strict_types=1);

function display_login_err(){
    if(isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        echo "<br>";

        foreach($errors as $error){
            echo '<p class="form-error">'.$error.'</p>';
        }
    }
}






?>