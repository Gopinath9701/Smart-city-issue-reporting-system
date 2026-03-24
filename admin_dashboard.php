<?php 
session_start();    

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$total_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM complaints");
$total = mysqli_fetch_assoc($total_q)['total'];

$pending_q = mysqli_query($conn, "SELECT COUNT(*) as pending FROM complaints WHERE status='Open'");
$pending = mysqli_fetch_assoc($pending_q)['pending'];

$resolved_q = mysqli_query($conn, "SELECT COUNT(*) as resolved FROM complaints WHERE status='Resolved'");
$resolved = mysqli_fetch_assoc($resolved_q)['resolved'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Overview | Smart City</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
        }
        .navbar-brand strong {
            font-weight: 800;
        }
        .stat-card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
        }
        .badge-open {
            background-color: #f1c40f;
            color: #212529;
        }
        .badge-resolved {
            background-color: #2ecc71;
        }
        .badge-closed {
            background-color: #e74c3c;
        }
        .table thead th {
            background-color: #f8f9fa;
        }
        .card-header {
            border-bottom: none;
        }
        .btn-manage {
            padding: 0.25rem 0.6rem;
            font-size: 0.8rem;
            border-radius: 999px;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                🏙️ <strong>SmartCity</strong> Admin
            </a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container mb-5">
        <!-- OVERVIEW TITLE -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">System Overview</h2>
        </div>

        <!-- STATS CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card stat-card border-0">
                    <div class="card-body text-center border-top border-3 border-primary">
                        <p class="stat-number text-primary"><?php echo $total; ?></p>
                        <p class="text-muted fw-semibold mb-0">Total Received</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card stat-card border-0">
                    <div class="card-body text-center border-top border-3 border-warning">
                        <p class="stat-number text-warning"><?php echo $pending; ?></p>
                        <p class="text-muted fw-semibold mb-0">Pending Issues</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card stat-card border-0">
                    <div class="card-body text-center border-top border-3 border-success">
                        <p class="stat-number text-success"><?php echo $resolved; ?></p>
                        <p class="text-muted fw-semibold mb-0">Resolved Cases</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- REGISTER NEW OFFICER -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">😊 Register New Department Officer</h5>
            </div>
            <div class="card-body">
                <form action="add_officer_logic.php" method="POST">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <input type="text" class="form-control" name="full_name" placeholder="Officer Name" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Official Email" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="text" class="form-control" name="phone" placeholder="Contact Number" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-select" name="department" required>
                                <option value="">Assign Department</option>
                                <option value="Roads">Roads & Transport</option>
                                <option value="Electricity">Electricity</option>
                                <option value="Water Supply">Water Supply</option>
                                <option value="Sanitation">Sanitation</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Set Temporary Password" required>
                        </div>
                        <div class="col-12 col-md-6 d-grid">
                            <button type="submit" class="btn btn-primary" name="add_officer">
                                Create Officer Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- RECENT ACTIVITY TABLE -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Recent Activity Across All Departments</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th>Citizen</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT complaints.*, users.full_name FROM complaints 
                                      JOIN users ON complaints.user_id = users.id 
                                      ORDER BY created_at DESC LIMIT 10";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $statusClass = '';
                                if($row['status'] === 'Open') $statusClass = 'badge-open';
                                elseif($row['status'] === 'Resolved') $statusClass = 'badge-resolved';
                                elseif($row['status'] === 'Closed') $statusClass = 'badge-closed';

                                echo "<tr>
                                        <td>#{$row['id']}</td>
                                        <td>{$row['full_name']}</td>
                                        <td>{$row['category']}</td>
                                        <td>
                                            <span class='badge {$statusClass}'>{$row['status']}</span>
                                        </td>
                                        <td class='text-center'>
                                            <a href='update_status.php?id={$row['id']}' class='btn btn-sm btn-outline-primary btn-manage'>
                                                Manage
                                            </a>
                                        </td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
