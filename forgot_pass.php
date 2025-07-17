<?php
require_once("database.php");
require_once("send_reset.php");

// storing messages after click the send reset link button 
$message = "";
$message_succ = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Generate a token
        $token = bin2hex(random_bytes(32));

        // Save token with 1-hour expiry
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, token_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // Send email
        $sent = sendResetEmail($email, $token);

        if ($sent) {
            $message_succ = "✅ A password reset link has been sent to your email.";
        } else {
            $message = "❌ Failed to send reset email. Please try again.";
        }
    } else {
        $message = "⚠️ Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot_pass.css">
</head>
<body>
    <div class="container">
        <form action="forgot_pass.php" method="POST">
            <h2 class="title">Forgot Password</h2>

            <?php if (!empty($message_succ)): ?>
                <p class="form-succ"><?= htmlspecialchars($message_succ); ?></p>
            <?php elseif (!empty($message)): ?>
                <p class="form-error"><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <input type="email" name="email" class="email_input" placeholder="Enter your email" required><br>
            <button type="submit" class="submit_button">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
