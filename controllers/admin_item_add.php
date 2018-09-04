<?php
session_start();
require 'connect.php';
$name = mysqli_escape_string($conn, $_POST['item_name']);
$description = mysqli_escape_string($conn, $_POST['item_description']);
$price = $_POST['item_price'];
$image = "assets/images/".$_FILES['item_image']['name'];
$category_id = mysqli_escape_string($conn, $_POST['item_category_id']);


$has_image = (file_exists($_FILES['item_image']['tmp_name']) && is_uploaded_file($_FILES['item_image']['tmp_name']));
if ($has_image) {
    move_uploaded_file($_FILES['item_image']['tmp_name'], "../".$image);
    
    $sql = "INSERT INTO items (name, description, price, image, category_id) VALUES ('$name', '$description', $price, '$image', $category_id)";
} else {
    $sql = "INSERT INTO items (name, description, price, image, category_id) VALUES ('$name', '$description', $price, 'assets/images/book-cover-placeholder.jpg', $category_id)";
}
mysqli_query($conn,$sql) or die(mysqli_error($conn));

// $_SESSION['success_message'] = "$name Added Successfully";

header('location: ../index.php');