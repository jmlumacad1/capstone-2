<?php
require 'connect.php';

$id = $_POST['id'];
$sql = "DELETE FROM items WHERE id = $id";
mysqli_query($conn, $sql);