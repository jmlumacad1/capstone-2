<?php
session_start();

$id = $_POST['id'];
$quantity = $_POST['quantity'];
$_SESSION['cart'][$id] = $quantity;

print_r($_SESSION['cart']);