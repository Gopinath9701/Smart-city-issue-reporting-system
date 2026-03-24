<?php
session_start();
include 'db_connect.php';
if(!isset($_SESSION['otp_verified'])) { 
    header("Location: forgot_password.php"); 
    exit();
}
if(isset($_POST['reset_pass'])) {
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    if($new_pass === $confirm_pass && strlen($new_pass) >= 6) {
        $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $contact = $_SESSION['reset_contact'];
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ? OR phone = ?");
        $stmt->bind_param("sss", $hashed_pass, $contact, $contact);
        if($stmt->execute()) {
            session_unset();
            session_destroy();
            echo "<script>alert('✅ Password reset successful! Redirecting to login...'); window.location='login.php';</script>";
            exit();
        } else {
            $error = "Update failed. Try again.";
        }
    } else {
        $error = "Passwords don't match or too short (min 6 chars)!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password - Smart City Portal</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; padding: 20px 0; }
        .auth-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 420px; width: 100%; margin: auto; padding: 2.5rem; }
        .form-control { border-radius: 12px; border: 2px solid #e9ecef; padding: 0.875rem 1.25rem; transition: all 0.3s; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25); }
        .btn-success { background: linear-gradient(135deg, #28a745, #20c997); border: none; border-radius: 12px; font-weight: 600; padding: 0.875rem; width: 100%; }
        .btn-success:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card auth-card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <h2 class="mb-3">🔐 New Password</h2>
                            <p class="text-muted">Enter your new secure password</p>
                        </div>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <input type="password" class="form-control" name="new_pass" 
                                       placeholder="New password (min 6 chars)" required minlength="6">
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="confirm_pass" 
                                       placeholder="Confirm new password" required minlength="6">
                            </div>
                            <button type="submit" class="btn btn-success btn-lg" name="reset_pass">
                                ✅ Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
