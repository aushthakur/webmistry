<?php
include_once('db_connect.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['user'];
$query = "SELECT * FROM registration WHERE email = '$email'";
$data = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($data);

// fallback if image not uploaded
$profilePic = !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .profile-container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
        }
        .profile-pic {
            height: 120px;
            width: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        h3 { margin-bottom: 30px; }
        .info-label { font-weight: 600; color: #555; }
    </style>
</head>
<body>

<div class="container profile-container text-center">
    <img src="<?php echo $profilePic; ?>" alt="Profile Picture" class="profile-pic">
    <h3><?php echo $row['first_name'] . " " . $row['last_name']; ?></h3>
    <div class="text-start mt-4">
        <p><span class="info-label">Email:</span> <?php echo $row['email']; ?></p>
        <p><span class="info-label">Mobile:</span> <?php echo $row['mobile']; ?></p>
        <p><span class="info-label">City:</span> <?php echo $row['city']; ?></p>
        <p><span class="info-label">Address:</span> <?php echo $row['address']; ?></p>
        <p><span class="info-label">Shift Time:</span> <?php echo $row['shift_start'] . " to " . $row['shift_end']; ?></p>
    </div>
    <a href="settings.php" class="btn btn-primary mt-3">Edit Profile</a>
</div>

</body>
</html>
