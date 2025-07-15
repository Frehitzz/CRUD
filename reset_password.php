<?php
require_once("database.php");

$message = "";

// Step 1: Handle GET (show form if token is valid)
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is not expired
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expire > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        $message = "Invalid or expired token.";
    }
}

// Step 2: Handle POST (process password reset)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $message = "Please fill in all fields.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    } elseif (strlen($newPassword) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // Find user again by token
        $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expire > NOW()");
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET pass = :password, reset_token = NULL, token_expire = NULL WHERE reset_token = :token");
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":token", $token);
            $stmt->execute();

            $message = "Password has been reset successfully. You can now <a href='login.php'>log in</a>.";
        } else {
            $message = "Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="css/reset_password.css">
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>

    <?php if (!empty($message)): ?>
      <p class="form-error"><?= $message ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['token']) && empty($message)): ?>
    <form action="reset_password.php" method="POST">
      <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']); ?>">
      <input type="password" name="new_password" placeholder="New Password" required><br>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
      <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
  </div>
</body>
</html>

