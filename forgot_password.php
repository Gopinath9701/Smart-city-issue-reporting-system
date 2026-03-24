<?php 
session_start();
include 'db_connect.php'; 

function generateOTP() {
    $otp = '';
    for($i = 0; $i < 6; $i++) {
        $otp .= strval(rand(0, 9));
    }
    return $otp;
}

$error = $success = "";
if (isset($_POST['send_otp'])) {
    $contact = trim(mysqli_real_escape_string($conn, $_POST['contact']));
    
    // Find user by email or phone
    $user_check = mysqli_query($conn, 
        "SELECT id, phone, email FROM users WHERE email = '$contact' OR phone = '$contact' LIMIT 1"
    );
    
    if ($user_check && mysqli_num_rows($user_check) > 0) {
        $user_row = mysqli_fetch_assoc($user_check);
        $phone = $user_row['phone'];
        
        // Clean and format phone to 91XXXXXXXXXX
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($phone) == 10 && $phone[0] >= '6' && $phone[0] <= '9') {
            $phone = '91' . $phone;
        } elseif (strlen($phone) == 11 && $phone[0] == '0') {
            $phone = '91' . substr($phone, 1);
        } elseif (strlen($phone) != 12 || substr($phone, 0, 2) != '91') {
            $error = "Invalid phone format in database. Expected 10-digit mobile starting with 6-9.";
            $phone = null;
        }
        
        if ($phone && strlen($phone) == 12) {
            $otp = generateOTP();
            $_SESSION['temp_otp'] = $otp;
            $_SESSION['reset_phone'] = $phone;
            $_SESSION['reset_contact'] = $contact;
            $_SESSION['otp_time'] = time();
            
            $message = "Smart City Portal Password Reset OTP: $otp. Valid for 5 minutes. Do not share.";
            $encoded_message = urlencode($message);
            $whatsapp_url = "https://wa.me/{$phone}?text={$encoded_message}";
            
            $success = "OTP generated: $otp (check console). WhatsApp will open...";
            ?>
            <script>
                console.log('WhatsApp URL: <?php echo $whatsapp_url; ?>');
                console.log('OTP: <?php echo $otp; ?>');
                var link = document.createElement('a');
                link.href = '<?php echo $whatsapp_url; ?>';
                link.target = '_blank';
                link.id = 'whatsapp-link';
                link.style.display = 'none';
                document.body.appendChild(link);
                
                setTimeout(function() {
                    document.getElementById('whatsapp-link').click();
                    setTimeout(function() {
                        window.location.href = 'verify_otp.php?phone=<?php echo urlencode($phone); ?>';
                    }, 1000);
                }, 500);
            </script>
            <?php
        } else {
            $error = "No valid Indian mobile number found for this account.";
        }
    } else {
        $error = "No account found with that email/phone.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Smart City Portal</title>
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
        .auth-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: none;
            max-width: 420px;
            width: 100%;
            margin: auto;
            padding: 2.5rem;
        }
        .auth-card h2 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .alert {
            border-radius: 12px;
            border: none;
            font-weight: 500;
        }
        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 576px) {
            .auth-card { margin: 1rem; padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card auth-card">
                    <div class="card-body text-center">
                        <h2 class="mb-3">Reset Password</h2>
                        <p class="text-muted mb-4">Enter your registered Phone/Email to receive 6-digit OTP on WhatsApp</p>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if(!empty($success)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                            <p class="text-info small mt-2">Check browser console (F12) for OTP. WhatsApp opened automatically.</p>
                        <?php endif; ?>

                        <?php if(empty($success)): ?>
                        <form method="POST">
                            <div class="mb-4">
                                <input type="text" class="form-control" name="contact" 
                                       placeholder="Phone (XXXXXXXXXX) or Email" required>
                            </div>
                            <button type="submit" class="btn btn-primary mb-4" name="send_otp">
                                Send WhatsApp OTP
                            </button>
                        </form>
                        <?php endif; ?>

                        <p class="mb-0">
                            <a href="login.php" class="back-link">← Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
