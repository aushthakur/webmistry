<?php
$hostname = "localhost";
$username = "u664832832_user";
$password = "9H3CB@CnHp=G";
$dbname   = "u664832832_web"; // ✅ Fix was needed here

$con = mysqli_connect($hostname, $username, $password, $dbname)
    or die("Database error: " . mysqli_connect_error());
?>
