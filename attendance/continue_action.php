<?php
session_start();
include('db_connect.php');

$email = $_SESSION['user'];
$today = date('Y-m-d');
$continue_time = date('H:i:s');

mysqli_query($con, "UPDATE attendance SET break_started=0, continue_time='$continue_time' WHERE email='$email' AND log_date='$today'");
