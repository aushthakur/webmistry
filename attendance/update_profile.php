<?php
include_once('db_connect.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$shift_start = $_POST['shift_start'];
$shift_end = $_POST['shift_end'];

// File upload
$uploadDir = 'uploads/';
$uploadPath = '';

if (!empty($_FILES['profile_pic']['name'])) {
    $fileName = time() . "_" . basename($_FILES['profile_pic']['name']);
    $uploadPath = $uploadDir . $fileName;
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadPath);
    $query = "UPDATE registration SET first_name='$first_name', last_name='$last_name', shift_start='$shift_start', shift_end='$shift_end', profile_pic='$uploadPath' WHERE email='$email'";
} else {
    $query = "UPDATE registration SET first_name='$first_name', last_name='$last_name', shift_start='$shift_start', shift_end='$shift_end' WHERE email='$email'";
}

if (mysqli_query($con, $query)) {
    header("Location: profile.php?msg=updated");
} else {
    echo "Update failed.";
}
?>
