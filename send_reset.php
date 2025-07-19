<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//MAKE SURE THAT THE FILE NAMe THAT CONTAINED THE PHPMAILER IS SRC FOLDER
//src = is the name of the folder 
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';


function sendResetEmail($userEmail, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'fritzharlydegamo@gmail.com'; // Your Gmail
        $mail->Password   = 'erehrutllkltdvel'; // App password, NOT Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        //the Username and setfrom() must be same
        $mail->setFrom('fritzharlydegamo@gmail.com', 'Login system');
        $mail->addAddress($userEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        
        //the link here is where the file path where do you want to 
        //got the user after entering their gmail
        $mail->Body    = "Click the link below to reset your password:<br><br>
            <a href='http://localhost/codes/CRUD/reset_password.php?token=$token'>Reset Password</a>";
        

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
