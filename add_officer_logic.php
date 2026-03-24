<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized access.");
}
if (isset($_POST['add_officer'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dept = mysqli_real_escape_string($conn, $_POST['department']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'officer';
    $sql = "INSERT INTO users (full_name, email, phone, password, role, department) 
            VALUES ('$name', '$email', '$phone', '$pass', '$role', '$dept')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Officer Added Successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>