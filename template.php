<?php session_start(); ?>
<?php
	if (isset($_SESSION['logged_in'])) {
		$logged_in = $_SESSION['logged_in'];
	}
?>
<?php require 'controllers/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<title> <?php get_title(); ?> </title>

	<?php require_once 'partials/header.php'; ?>
</head>
<body>
	<?php
		require_once 'partials/nav.php';
		get_content();
		require_once 'partials/footer.php';
	?>
</body>
</html>
<?php mysqli_close($conn); ?>