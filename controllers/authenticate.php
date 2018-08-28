<?php

session_start();
require 'connect.php';

$username = $_POST['username'];
$password = sha1($_POST['password']);

$sql = "
	SELECT id, username, role_id FROM users WHERE
		username = '$username' AND
		password = '$password'
";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
	$_SESSION['logged_in'] = mysqli_fetch_assoc($result);
	if ($_SESSION['logged_in']['role_id'] == 1) {
		if (isset($_SESSION['cart'])) {
			unset($_SESSION['cart']);
		}
	}
	header('location: ../index.php');
} else {
	$_SESSION['error_login'] = "Incorrect username/password. Please login again.";
	header('location: ../login.php');
}