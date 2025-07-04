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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f6f9; }
        .settings-form {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #0066ff;
            box-shadow: 0 0 5px rgba(0, 102, 255, 0.3);
        }
    </style>
</head>
<body>

<div class="container settings-form">
    <h3 class="mb-4 text-center">🛠 Update Profile Settings</h3>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Shift Start Time</label>
            <input type="time" name="shift_start" class="form-control" value="<?php echo $row['shift_start']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Shift End Time</label>
            <input type="time" name="shift_end" class="form-control" value="<?php echo $row['shift_end']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control">
            <?php if (!empty($row['profile_pic'])): ?>
                <img src="<?php echo $row['profile_pic']; ?>" style="height: 80px; margin-top: 10px;" alt="Current Pic">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
    </form>
</div>

</body>
</html>
