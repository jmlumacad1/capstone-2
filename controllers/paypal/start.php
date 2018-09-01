<?php

require '../vendor/autoload.php';
define('SITE_URL','http://localhost:8080/capstone-2/');
$paypal = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AdQzyT9O81PIluWsf7HCD7KnZTFq7nvV3bQ1HmTQICCRcF6zMexq31GJZ1Rh3AnULPoyXXYNlPPVokZw',
		'EEdv1s43WEHUK_RqitpjPLvR9ynxdBr2ABKQmXHowmM6XuWZGXuI8A4v7WHXAW3z7jFeJ5gOhDNMlEBV')
);

?>