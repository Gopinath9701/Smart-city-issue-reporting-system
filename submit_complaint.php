<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['user_id'];
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $pin = mysqli_real_escape_string($conn, $_POST['pincode']); 

    $sql = "INSERT INTO complaints (user_id, category, description, location, area, pincode, status) 
            VALUES ('$uid', '$cat', '$desc', '$loc', '$area', '$pin', 'Open')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Complaint Registered!'); window.location='citizen_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>