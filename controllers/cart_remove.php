<?php
session_start();
if (isset($_POST['id'])) {
	$id = $_POST['id'];
	unset($_SESSION['cart'][$id]);
	if (count($_SESSION['cart']) == 0) {
		unset($_SESSION['cart']);
	}
}