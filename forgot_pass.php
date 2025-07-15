<?php
require_once("database.php");
require_once("send_reset.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    // Check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Save token to database
    $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, token_expire = NOW()
             + INTERVAL 1 HOUR WHERE email = :email");
    $stmt->bindParam(":token", $token);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    // Send the reset email using PHPMailer
    $sent = sendResetEmail($email, $token);

    if ($sent) {
        $message = "A password reset link has been sent to your email.";
    } else {
        $message = "Failed to send reset email. Please try again.";
    }
    } else {
    $message = "Email not found.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/forgot_pass.css">
</head>
<body>
    <div class="container">
        <form action="forgot_pass.php" method="POST">
            <?php if (!empty($message)) : ?>
                <p class="form-error"><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <input type="text" class="email_input" name="email" placeholder="Enter your email"><br>
            <button type="submit" class="submit_button">Send Reset Link</button>
        </form>
    </div>
</body>
</html>