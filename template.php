<?php session_start(); ?>
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

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Compiled and minified Materialize JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

	<!-- external js -->
	<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>