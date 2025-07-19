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

    // if empty
    if (empty($newPassword) || empty($confirmPassword)) {
        $message = "Please fill in all fields.";
    } 
    // if the pass is not same on confirm pass
    elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    }
    // password limit
    elseif (strlen($newPassword) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        // if there is no problem
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
  <link rel="stylesheet" href="css/reset_pass.css">
  <link rel="stylesheet" href="css/signup.css">
</head>
<body>
  <div class="container">

    <?php if (!empty($message)): ?>
      <p class="form-error"><?= $message ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['token']) && empty($message)): ?>
    <form action="reset_password.php" method="POST">
      <h2>Reset Password</h2>
      <!-- keeps the token available for the POST request. -->
      <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']); ?>">
      <input class="input_pass" id="reset_pass" type="password" name="new_password" placeholder="New Password" required oninput="pass_strength(this.value)">
      <div class="strength-indicator">
          <div class="strength-bar" id="strengthBar"></div><!--password bar-->
      </div>
      <input class="input_pass" id="reset_conpass" class="con_pass" type="password" name="confirm_password" placeholder="Confirm Password" required><br>
      <input class="mycheckb" type="checkbox" onclick="passcheckb_manage()"><label>Show Password</label>
      <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
  </div>
  <script src="js/resetpass.js"></script>
</body>
</html>

