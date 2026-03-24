<?php
include 'db_connect.php';
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']); 

    $query = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['dept'] = $row['department']; 

            header("Location: " . $row['role'] . "_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Account not found for this role'); window.location='login.php';</script>";
    }
}
?>