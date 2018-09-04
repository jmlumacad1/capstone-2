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
    $_SESSION['success_register'] = "Successfully registered.";
} else {
    $_SESSION['error_register'] = "Registration failed.";
}

header('location: ../index.php');