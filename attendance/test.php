<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('db_connect.php');

if (!$con) {
    die("DB connection failed: " . mysqli_connect_error());
}
echo "✅ Database Connected Successfully!";
