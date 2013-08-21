<?php
include 'tax-cloud/func.taxcloud.php';
$destination = new Address();
$destination->setAddress1("600");
$destination->setAddress2("17th Street NW");
$destination->setCity("Washington DC");
$destination->setState("DC"); // Two character state abbreviation
$destination->setZip5("20508");
$destination->setZip4('');
echo '<pre>';

$err = Array();
/* verify address and check for error */
$verifiedAddress = func_taxcloud_verify_address($destination, $err);
/*
var_dump($err);
var_dump($verifiedAddress);
 */

/* set products here */
$products = Array();

$product = Array();
$product['productid'] = 1; //Your system's product ID
$product['price'] = '19.99'. //product price
$product['qty'] = 1; //product quantity
$product['tic'] = "00000"; //product quantity
$products[0] = $product;

$product = Array();
$product['productid'] = 2; //Your system's product ID
$product['price'] = '29.99'. //product price
$product['qty'] = 2; //product quantity
$product['tic'] = "00000"; //product quantity
$products[1] = $product;


/* company address */
$origin = new Address();
$origin->setAddress1('2589 BITTERROOT PL');
$origin->setAddress2('HGHLNDS RANCH, CO');
$origin->setCity('Colorado');
$origin->setState('CO');
$origin->setZip5('80129');
$origin->setZip4('');

$shipping = 5; 

$errMsg = Array();

// Now call TaxCloud - $taxes will contain the total tax amount for the order
$taxes = func_taxcloud_lookup_tax($products, $origin, $verifiedAddress, $shipping, $errMsg);

var_dump($errMsg);
var_dump($taxes);

$err = Array();

$authorize = func_taxcloud_authorized_with_capture(10, $err);

var_dump($authorize);
var_dump($err);

$cerr = Array();
$captured = func_taxcloud_capture(10, $err);

var_dump($captured);
var_dump($cerr);

