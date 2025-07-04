<?php
include_once('db_connect.php');
error_reporting(0);

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['pass'];
$cpassword = $_POST['cpass'];
$mob = $_POST['mobile'];
$city = $_POST['city'];
$address = $_POST['add'];
$doj = $_POST['doj'];
$shift_start = $_POST['shiftStart'];
$shift_end = $_POST['shiftEnd'];

$targetDir = "uploads/";
$profilePicName = "";

if (!empty($_FILES['profilePic']['name'])) {
    $fileName = basename($_FILES['profilePic']['name']);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
            $profilePicName = $targetFilePath;
        } else {
            echo "<span class='text-danger'>Error uploading profile picture.</span>";
            exit;
        }
    } else {
        echo "<span class='text-danger'>Invalid file type for profile picture.</span>";
        exit;
    }
}

if (
    empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($cpassword) ||
    empty($mob) || empty($city) || empty($address) || empty($doj) || empty($shift_start) || empty($shift_end)
) {
    echo "<span class='text-warning text-center'>Please fill in all the details.</span>";
} else {
    if ($password !== $cpassword) {
        echo "<span class='text-warning text-center'>Passwords do not match.</span>";
    } else {
        $sqlquery = "SELECT * FROM registration WHERE email = '$email'";
        $query = mysqli_query($con, $sqlquery);
        $total = mysqli_num_rows($query);

        if ($total == 0) {
            $sqlInsert = "INSERT INTO registration 
            (first_name, last_name, email, password, mobile, city, address, date_of_joining, shift_start, shift_end, profile_pic)
            VALUES 
            ('$firstname', '$lastname', '$email', '$password', '$mob', '$city', '$address', '$doj', '$shift_start', '$shift_end', '$profilePicName')";

            $sqlexecute = mysqli_query($con, $sqlInsert);
            if ($sqlexecute) {
                echo "<span class='text-success'>Registration completed successfully.</span>";
            } else {
                echo "<span class='text-danger'>Registration failed. Please try again.</span>";
            }
        } else {
            echo "<span class='text-warning'>Email is already registered. Try another one.</span>";
        }
    }
}
?>
