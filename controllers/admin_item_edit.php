<?php
session_start();
require 'connect.php';
$id = $_GET['id'];
$name = mysqli_escape_string($conn, $_POST['item_name']);
$description = mysqli_escape_string($conn, $_POST['item_description']);
$price = $_POST['item_price'];
$category_id = mysqli_escape_string($conn, $_POST['item_category_id']);
$has_image = (file_exists($_FILES['item_image']['tmp_name']) && is_uploaded_file($_FILES['item_image']['tmp_name']));
if ($has_image) {
	$image = "assets/images/".$_FILES['item_image']['name'];
	move_uploaded_file($_FILES['item_image']['tmp_name'], "../".$image);
	$sql = "UPDATE items SET
		name = '$name',
		description = '$description',
		price = $price,
		image = '$image',
		category_id = $category_id
		WHERE id = $id";
} else {
	$sql = "UPDATE items SET
		name = '$name',
		description = '$description',
		price = $price,
		category_id = $category_id
		WHERE id = $id";
}
mysqli_query($conn,$sql) or die(mysqli_error($conn));

// $_SESSION['success_message'] = "$name Added Successfully";

header('location: ../index.php');