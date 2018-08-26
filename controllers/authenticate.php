<?php

session_start();
require 'connect.php';

$username = $_POST['username'];
$password = sha1($_POST['password']);

$sql = "
	SELECT * FROM users WHERE
		username = '$username' AND
		password = '$password'
";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
	$_SESSION['logged_in_user'] = $username;
} else {
	$_SESSION['error_login'] = "Incorrect username/password. Please login again.";
}

header('location: ../index.php');