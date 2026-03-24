<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart City Portal</title>
    <!-- Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 4rem 1rem;
            text-align: center;
        }
        .hero-section h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .hero-section p {
            font-size: 1rem;
            opacity: 0.9;
        }
        footer {
            text-align:center;
            padding: 40px 10px;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                🏙️ <strong>SmartCity</strong> Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="btn btn-primary ms-lg-2 mt-2 mt-lg-0" href="register.php">
                        Join Us
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero-section">
        <div class="container">
            <h2>Raise your complaints for better city</h2>
            <p>Report issues, track repairs, and improve the city together.</p>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title">Step 1</h3>
                            <p class="card-text">Register your citizen account securely.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title">Step 2</h3>
                            <p class="card-text">Submit complaints with proper locations.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title">Step 3</h3>
                            <p class="card-text">Track progress in real-time until fixed.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>Team: KAVYA SRI[24211A6716], GOPINATH[24211A6718], POOJA[24211A6719]</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
