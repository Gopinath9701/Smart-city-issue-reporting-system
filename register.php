<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Create Account | Smart City</title>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }
        .error-msg {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: -8px;
            margin-bottom: 10px;
            display: none; 
        }
        .input-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container">
            <a class="navbar-brand" href="#">
                🏙️ <strong>SmartCity</strong> Portal
            </a>
            <div class="d-flex">
                <a href="index.php" class="nav-link">Home</a>
            </div>
        </div>
    </nav>
    <div class="container auth-wrapper">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card shadow-sm" style="width: 100%; max-width: 450px; margin: 0 auto;">
                    <div class="card-body">
                        <h2 style="text-align: center; margin-bottom: 10px;">Citizen Registration</h2>
                        <p style="text-align: center; color: #666; margin-bottom: 25px;">Join the community to improve city.</p>
                        
                        <form id="regForm" action="register_logic.php" method="POST" onsubmit="return validateForm()">
                            
                            <div class="input-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Enter your full name" required>
                                <div id="nameError" class="error-msg">Name must be at least 3 characters.</div>
                            </div>

                            <div class="input-group">
                                <label>Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="example@mail.com" required>
                                <div id="emailError" class="error-msg">Please enter a valid email.</div>
                            </div>

                            <div class="input-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="10-digit mobile number" required>
                                <div id="phoneError" class="error-msg">Enter a valid 10-digit number.</div>
                            </div>

                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Min 8 characters" required>
                            </div>

                            <div class="input-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Repeat password" required>
                                <div id="passError" class="error-msg">Passwords do not match!</div>
                            </div>

                            <button type="submit" name="register" class="btn btn-primary w-100" style="margin-top: 10px;">Create Account</button>
                        </form>
                        
                        <p style="text-align: center; margin-top: 20px;">
                            Already have an account? 
                            <a href="login.php" style="color: var(--accent); font-weight: 600;">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function validateForm() {
        let isValid = true;
        document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');
        
        const name = document.getElementById('full_name').value;
        if(name.length < 3) {
            document.getElementById('nameError').style.display = 'block';
            isValid = false;
        }
        const phone = document.getElementById('phone').value;
        const phoneRegex = /^[0-9]{10}$/;
        if(!phoneRegex.test(phone)) {
            document.getElementById('phoneError').style.display = 'block';
            isValid = false;
        }
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        if(pass !== confirm) {
            document.getElementById('passError').style.display = 'block';
            isValid = false;
        }
        return isValid;
    }
    </script>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
