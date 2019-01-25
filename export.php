<?php

/**
 * @author William Byrne <wbyrne@razoyo.com>
 * Documentation: https://github.com/razoyo/devtest
 */

require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/dev-lib.php';

$apiWsdl = 'https://www.shopjuniorgolf.com/api/?wsdl';
$apiUser = 'devtest';
$apiKey ='ku%64TeYMo5mAIFj8e';

$formatKey = 'csv'; // csv, xml, or json

// Connect to SOAP API using PHP's SoapClient class
// Feel free to create your own classes to organize code
$soap = new SoapClient($apiWsdl);
// ...

$session = $soap->login($apiUser, $apiKey);
$products = $soap->call($session, 'product.list');


print_r($products[0]);

// You will need to create a FormatFactory.
$factory = new FormatFactory(); 
$format = $factory->create($formatKey);

// See ProductOutput in raz-lib.php for reference
$output = new ProductOutput();
// ...
$output->format();
