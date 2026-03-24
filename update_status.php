<?php 
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'officer')) {
    header("Location: login.php"); 
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: login.php"); 
    exit();
}
$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM complaints WHERE id = $id");
$data = mysqli_fetch_assoc($result);
if (isset($_POST['update'])) {
    $status = $_POST['status'];
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $sql = "UPDATE complaints SET status='$status', officer_remarks='$remarks' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $target = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'officer_dashboard.php';
        echo "<script>alert('Status Updated Successfully!'); window.location='$target';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Complaint | Smart City</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Link href="bootstrap.min.css" rel="stylesheet">
    <Link href="fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto; border-radius: 8px;">
                    <div class="card-body">
                        <h2 class="mb-3">Manage Complaint #<?php echo $id; ?></h2>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($data['category']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($data['description']); ?></p>
                        <hr class="my-3">
                        <form method="POST">
                            <div class="mb-3">
                                abel class="form-label fw-bold">Update Status</label>
                                <select name="status" class="form-select">
                                    <option value="Open" <?php if($data['status']=='Open') echo 'selected'; ?>>Open</option>
                                    <option value="In Progress" <?php if($data['status']=='In Progress') echo 'selected'; ?>>In Progress</option>
                                    <option value="Resolved" <?php if($data['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                abel class="form-label fw-bold">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="4" 
                                          placeholder="Detail the action taken..."><?php echo htmlspecialchars($data['officer_remarks']); ?></textarea>
                            </div>
                            <button type="submit" name="update" 
                                    class="btn btn-success w-100 mb-2">
                                Save Changes
                            </button>
                            <?php $back = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'officer_dashboard.php'; ?>
                            <a href="<?php echo $back; ?>" 
                               class="d-block text-center mt-2 text-decoration-none text-muted">
                                Cancel and Go Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>
</html>
