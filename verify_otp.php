<?php
session_start();
include 'db_connect.php';
if(!isset($_SESSION['temp_otp'])) { 
    header("Location: forgot_password.php"); 
    exit();
}
if(isset($_POST['verify_btn'])) {
    if(time() - $_SESSION['otp_time'] > 300) {
        $error = "OTP expired! <a href='forgot_password.php'>Resend</a>.";
        unset($_SESSION['temp_otp']);
    } elseif($_POST['user_otp'] == $_SESSION['temp_otp']) {
        $_SESSION['otp_verified'] = true;
        unset($_SESSION['temp_otp']);
        header("Location: reset_password_final.php");
        exit();
    } else {
        $error = "Invalid 6-digit OTP. Try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Smart City Portal</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .auth-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 420px; width: 100%; margin: auto; padding: 2.5rem; }
        .otp-input { font-size: 2rem !important; font-weight: 700 !important; letter-spacing: 20px !important; height: 70px !important; text-align: center; border: 3px solid #e9ecef !important; border-radius: 15px !important; background: #f8f9fa !important; }
        .otp-input:focus { border-color: #28a745 !important; box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25) !important; }
        .btn-success { background: linear-gradient(135deg, #28a745, #20c997); border: none; border-radius: 12px; font-weight: 600; padding: 0.75rem 2rem; }
        .btn-success:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3); }
        .phone-display { background: #f8f9fa; border-radius: 10px; padding: 0.75rem; font-family: monospace; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card auth-card">
                    <div class="card-body text-center">
                        <h2 class="mb-4">🔐 Verify OTP</h2>
                        <div class="phone-display mb-4 p-3">
                            Sent to: <strong><?php echo htmlspecialchars($_SESSION['reset_contact']); ?></strong>
                        </div>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-4">
                                <input type="number" class="form-control otp-input" name="user_otp" 
                                       placeholder="123456" maxlength="6" minlength="6" required 
                                       autocomplete="one-time-code">
                                <small class="text-muted mt-2">Enter 6-digit code from WhatsApp (5 min valid)</small>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3" name="verify_btn">
                                ✅ Verify OTP
                            </button>
                        </form>
                        <a href="forgot_password.php" class="btn btn-outline-secondary w-100">🔄 Resend OTP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
