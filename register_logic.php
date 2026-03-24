<?php
include 'db_connect.php';

if (isset($_POST['register'])) {
    // Escape strings to prevent SQL injection via CLI
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "INSERT INTO users (full_name, email, phone, password, role) 
            VALUES ('$name', '$email', '$phone', '$password', 'citizen')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>