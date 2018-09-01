<?php

require 'connect.php';

$order_id = $_POST['order_id'];
$status_id = $_POST['status_id'];

$sql = "INSERT INTO orders_statuss ( order_id, status_id ) VALUES ( $order_id, $status_id ) ";
mysqli_query($conn, $sql);

$sql = "UPDATE orders SET status_id = $status_id WHERE id = $order_id";
mysqli_query($conn, $sql);