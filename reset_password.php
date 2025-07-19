<?php
require_once("database.php");

$message = "";
$showForm = false;
$token = "";

// Step 1: Handle GET (show form if token is valid)
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is not expired
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expire > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $user = $stmt->fetch();

    //if there are ser found in the database
    if ($user) {
        $showForm = true;
    } else {
        $message = "Invalid or expired token.";
    }
}

function password_too_weak(string $newPassword){
    $strength = 0; // storing the strtength points here

    //Checks if the password have 8 or more char
    if(strlen($newPassword) >= 8) $strength++;

    //preg_match = checks if something exist like this in string 
    if(preg_match('/[a-z]/', $newPassword)) $strength++;
    if(preg_match('/[A-Z]/', $newPassword)) $strength++;
    if(preg_match('/[0-9]/',$newPassword)) $strength++;
    if(preg_match('/[^a-zA-Z0-9]/', $newPassword)) $strength++;

    return $strength < 4; // Less than 4 is considered weak
}

// Step 2: Handle POST (process password reset)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // First check if token is still valid
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expire > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $user = $stmt->fetch();

    // if no user found
    if (!$user) {
        $message = "Invalid or expired token.";
    } else {
        // if empty
        if (empty($newPassword) || empty($confirmPassword)) {
            $message = "Please fill in all fields.";
            $showForm = true; // Keep showing the form
        } 
        // if the pass is not same on confirm pass
        elseif ($newPassword !== $confirmPassword) {
            $message = "Passwords do not match.";
            $showForm = true; // Keep showing the form
        }
        // password limit
        elseif (strlen($newPassword) < 6) {
            $message = "Password must be at least 6 characters.";
            $showForm = true; // Keep showing the form
        }elseif (password_too_weak($newPassword)){
          $message = "The password is too weak. Please use at least 8 characters with uppercase, lowercase, numbers, and special characters.";
          $showForm = true;
        }
         else {
            // if there is no problem
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET pass = :password, reset_token = NULL, token_expire = NULL WHERE reset_token = :token");
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":token", $token);
            $stmt->execute();

            $message_succ = "Password has been reset successfully. You can now <a href='login.php'>log in</a>.";
            $showForm = false; // Hide form after successful reset
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
    <?php elseif (!empty($message_succ)): ?>
      <p class="form-error-succ"><?= $message_succ ?><p>
      <?php endif; ?>
    <!-- 
    THis check if the form is tre or false 
    if false the form will not show, if true the form is show
    -->
    <?php if ($showForm): ?> 
    <form action="reset_password.php" method="POST">
      <!-- If the $message is not empty display the message inside -->
      <h2>Reset Password</h2>
      <!-- keeps the token available for the POST request. -->
      <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
      <input class="input_pass" id="reset_pass" type="password" name="new_password" placeholder="New Password" oninput="pass_strength(this.value)">
      <div class="strength-indicator">
          <div class="strength-bar" id="strengthBar"></div><!--password bar-->
      </div>
      <input class="input_pass" id="reset_conpass" class="con_pass" type="password" name="confirm_password" placeholder="Confirm Password"><br>
      <div class="showpass-container">
        <input class="mycheckb" type="checkbox" onclick="passcheckb_manage()"><label>Show Password</label>
      </div>
      <button type="submit">Reset Password</button>
    </form>
     <?php endif; ?> <!-- end of the if statement -->
  </div>
  <script src="js/resetpass.js"></script>
</body>
</html>
