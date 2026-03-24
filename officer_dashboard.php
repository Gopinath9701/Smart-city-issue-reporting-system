<?php 
session_start();
include 'db_connect.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'officer') {
    header("Location: login.php");
    exit();
}

$dept = $_SESSION['dept']; 
$name = $_SESSION['user_name'];
$stats_q = mysqli_query($conn, "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'Open' THEN 1 ELSE 0 END) as pending
    FROM complaints WHERE category = '$dept'");
$stats = mysqli_fetch_assoc($stats_q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Dashboard | <?php echo htmlspecialchars($dept); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
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
            font-size: 2rem;
            font-weight: 800;
        }
        .badge-status {
            border-radius: 999px;
            padding: 0.25rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                🏙️ <strong>SmartCity</strong> <?php echo htmlspecialchars($dept); ?> Dept
            </a>
            <div class="d-flex text-white">
                <span class="me-3">
                    Welcome, <?php echo htmlspecialchars($name); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Departmental Tasks: <?php echo htmlspecialchars($dept); ?></h2>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <div class="card stat-card border-0 border-start border-4 border-primary">
                    <div class="card-body">
                        <p class="text-muted mb-1">Assigned to Department</p>
                        <p class="stat-number text-primary mb-0">
                            <?php echo $stats['total']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card stat-card border-0 border-start border-4 border-warning">
                    <div class="card-body">
                        <p class="text-muted mb-1">Pending Action</p>
                        <p class="stat-number text-warning mb-0">
                            <?php echo $stats['pending']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Recent Complaints</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Status</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM complaints WHERE category = '$dept' ORDER BY created_at DESC";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $status = $row['status'];
                                $badgeClass = 'bg-secondary';
                                if ($status === 'Open') $badgeClass = 'bg-primary';
                                if ($status === 'Resolved') $badgeClass = 'bg-success';
                                if ($status === 'In Progress') $badgeClass = 'bg-warning text-dark';

                                $shortDesc = strlen($row['description']) > 50 
                                    ? substr($row['description'], 0, 50) . '...' 
                                    : $row['description'];

                                echo "<tr>
                                        <td>#{$row['id']}</td>
                                        <td>
                                            <span class='badge badge-status $badgeClass'>"
                                                . htmlspecialchars($status) .
                                            "</span>
                                        </td>
                                        <td>". htmlspecialchars($shortDesc) ."</td>
                                        <td class='text-center'>
                                            <a href='update_status.php?id={$row['id']}' 
                                               class='btn btn-sm btn-outline-primary'>
                                                Update
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
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
