<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login.css">
<title>Login Page</title>
</head>
<body>
<div class="login-container">
  <div class="logo">
    <!-- Logo will be inserted here -->
    <img src="Wani-logo-color.png" alt="Company Logo">
  </div>
  <h2 >Sign in</h2>
  <form action="login.php" method="post">
    <div class="form-group">
      <input type="text" name="uname" placeholder="Username" required>
    </div>
    <div class="form-group">
      <input type="password" name="pword" placeholder="Password" required>
    </div>
    <button type="submit" class="login-button">Sign in</button>
    <a href="#" class="forgot-password">Forgot password?</a>
  </form>
</div>
</body>
</html>
