<?php
	require 'connect.php';
	$username = $_POST['username'];
	$sql = "
		SELECT * FROM users WHERE username = '$username'
	";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		echo "username already exists";
	} else {
		echo "username still available";
	}