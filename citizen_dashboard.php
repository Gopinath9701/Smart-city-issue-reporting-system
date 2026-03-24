<?php 
include 'db_connect.php';
session_start(); 
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$uid = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citizen Portal | Smart City</title>
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
        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .badge-status {
            padding: 0.25rem 0.5rem;
            border-radius: 0.4rem;
            font-size: 0.7rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                🏙️ <strong>SmartCity</strong> Citizen
            </a>
            <div class="d-flex text-white">
                <span class="me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title mb-1">📍 New Complaint</h3>
                        <p class="text-muted" style="font-size:0.85rem;">Report an issue in your locality.</p>
                        <form action="submit_complaint.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select Department</option>
                                    <option value="Roads">Roads & Transport</option>
                                    <option value="Electricity">Electricity</option>
                                    <option value="Water Supply">Water Supply</option>
                                    <option value="Sanitation">Sanitation</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control" name="pincode" id="pincode"
                                       placeholder="6-digit Pincode" maxlength="6" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Area/Locality</label>
                                <input type="text" class="form-control" name="area" id="area"
                                       placeholder="Auto-fills from Pincode..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description"
                                          placeholder="Describe the issue..." rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Landmark</label>
                                <input type="text" class="form-control" name="location"
                                       placeholder="Near which shop/building?">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Submit Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title mb-3">📋 My Recent Reports</h3>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Dept</th>
                                        <th scope="col">Issue</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM complaints WHERE user_id = '$uid' ORDER BY created_at DESC";
                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $status = $row['status'];
                                            $colorClass = 'bg-primary'; 
                                            if($status == 'Resolved') $colorClass = 'bg-success';
                                            if($status == 'In Progress') $colorClass = 'bg-warning text-dark';
                                            echo "<tr>";
                                            echo "<td><strong>" . htmlspecialchars($row['category']) . "</strong></td>";
                                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                            echo "<td>
                                                    <span class='badge badge-status $colorClass'>
                                                        " . htmlspecialchars($status) . "
                                                    </span>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td colspan='3' class='text-center text-muted py-5'>
                                                    No reports found. File your first complaint today!
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
        </div>
    </div>
    <script>
    document.getElementById('pincode').addEventListener('input', function() {
        let pin = this.value;
        if(pin.length === 6) {
            fetch(`https://api.postalpincode.in/pincode/${pin}`)
                .then(response => response.json())
                .then(data => {
                    if(data[0].Status === "Success") {
                        document.getElementById('area').value = data[0].PostOffice[0].Name;
                    } else {
                        alert("Pincode not found!");
                    }
                })
                .catch(err => console.log("Error fetching area"));
        }
    });
    </script>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
