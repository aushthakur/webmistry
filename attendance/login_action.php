<?php
include_once('db_connect.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$email = $_SESSION['user'];
$log_date = date('Y-m-d');
$login_time = date('H:i:s');

// Check if already logged in
$res = mysqli_query($con, "SELECT * FROM attendance WHERE email='$email' AND log_date='$log_date'");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    mysqli_query($con, "INSERT INTO attendance (email, log_date, login_time, break_started) VALUES ('$email', '$log_date', '$login_time', 0)");
    echo json_encode(['status' => 'logged_in', 'login_time' => $login_time]);
} else {
    echo json_encode(['status' => 'already_logged', 'login_time' => $data['login_time']]);
}
