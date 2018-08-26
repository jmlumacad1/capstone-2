<?php	

session_start();
require 'connect.php';

$username = $_POST['username'];
$password = sha1($_POST['password']);

$sql = "
	INSERT INTO users (username, password)
	VALUES ('$username', '$password')
";

if (mysqli_query($conn,$sql)) {
	echo "success";
} else {
	echo mysqli_error($conn);
}

$_SESSION['success_register'] = "Successfully registered.";
header('location: ../login.php');