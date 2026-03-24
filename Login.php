<?php 
include 'db_connect.php'; 
session_start();
 ?>
<!DOCTYPE html>
<html>
<head><title>Login - Smart City</title>
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-card">
        <h2>Login to Portal</h2>
        <form action="auth_logic.php" method="POST">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            
            <select name="role">
                <option value="citizen">Citizen</option>
                <option value="admin">Admin</option>
                <option value="officer">Officer</option>
            </select>
            
            <button type="submit" name="login">Login</button>
            <div style="margin-top: 15px; text-align: center;">
                <a href="forgot_password.php" style="color: #3498db; text-decoration: none;">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html>