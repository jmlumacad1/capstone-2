<?php 
session_start();

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require 'paypal/start.php';
require 'connect.php';

if(!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'])) {
	echo('error');
	die();
}

if((bool)$_GET['success'] === false) {
	echo('error');
	die();
}

$payment_id = $_GET['paymentId'];
$payer_id = $_GET['PayerID'];

$payment = Payment::get($payment_id, $paypal);
$execute = new PaymentExecution();
$execute->setPayerId($payer_id);

try {
	$result = $payment->execute($execute, $paypal);
	$result = json_decode($result);
	$invoice_number = $result->transactions[0]->invoice_number;
	foreach($result->payer->payer_info->shipping_address as $key => $address_piece) {
		if($key != 'recipient_name') {
			$address_array[] = $address_piece;
		}
	}
	$address = implode(' ', $address_array);
} catch(Execption $e) {
	$data = json_decode($e->getData());
	print_r($data);
	die();
}

$user_id = $_SESSION['logged_in']['id'];
$total_price = $_SESSION['total_price'];
$sql = "INSERT INTO orders (id, transaction_code, user_id, address, contact_number, status_id, date_created, payment_method_id, total_price) VALUES(null,'$invoice_number',$user_id,'$address',null,1,null,2,$total_price)";
mysqli_query($conn,$sql) or die(mysqli_error($conn));
$order_id = mysqli_insert_id($conn);

foreach($_SESSION['cart'] as $id => $quantity) {
	$sql = "INSERT INTO order_details VALUES(null,$id,$quantity,$order_id)";
	mysqli_query($conn,$sql) or die(mysqli_error($conn));
}

$sql = "INSERT INTO orders_statuss VALUES(null,$order_id,1,null)";
mysqli_query($conn,$sql) or die(mysqli_error($conn));

unset($_SESSION['cart']);
$_SESSION['success_message'] = "Payment Successful!";

header('location: ../index.php');


?>