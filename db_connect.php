<?php
$host = "localhost";
$user = "root"; 
$pass = "Gopinath_9701"; 
$dbname = "smart_city";
$port=3306;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>