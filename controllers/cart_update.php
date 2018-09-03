<?php
session_start();

$id = $_POST['id'];
$quantity = $_POST['quantity'];
$_SESSION['total_price'] += $_POST['price']*($quantity - $_POST['prev_qty']);
$_SESSION['cart'][$id] = $quantity;

print_r($_SESSION['cart']);