<?php

/**
 * @author William Byrne <wbyrne@razoyo.com>
 * Documentation: https://github.com/razoyo/devtest
 */

require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/dev-lib.php';
require_once __DIR__ . '/Soap.php';




$soap= new Soap();
$client = $soap->getClient();
$sessionId = $soap->getSession();

$products  = $client->call($sessionId, "catalog_product.list");
// echo "<pre>";
// print_r($products);


// $requestedFormat= $_GET['format'];
// You will need to create a FormatFactory.
$formatKey = 'xml'; // Change it to csv, xml, or json


$factory = new FormatFactory(); 
$factory->setProducts($products);
$format = $factory->create($formatKey);



// See ProductOutput in raz-lib.php for reference
$output = new ProductOutput();
// ...
$output->setFormat($format);

$output->format();
