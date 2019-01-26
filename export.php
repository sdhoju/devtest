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
$catalogProductEntity  = $soap->call($session, "catalog_product.list");

$numberOfProducts=20; 
$numberOfProducts=count($catalogProductEntity); 
 
/**
 *
 * Clean the  an object to an array
 *https://devdocs.magento.com/guides/m1x/api/soap/catalog/catalogProduct/catalog_product.list.html
 * @param    array  $catalogProductEntity 
 *
 */
function cleanProduct($catalogProductEntity){

    for($x = 0; $x < $numberOfProducts; $x++){

        $product= $catalogProductEntity[$x];
        $fields  = ['sku','name', 'price', 'short_description'];
        $catalogProductReturnEntity = $soap->call($session, 'catalog_product.info', $product['product_id'], $fields  );
        
        $product = [];
        foreach($fields as $field){
            if(isset($catalogProductReturnEntity[$field])!=null){
                $product[$field] = $catalogProductReturnEntity[$field];
            }
        }
        $products[] = $product;
    }

    return $products;
}

// echo "<pre>";
// print_r($products);



// You will need to create a FormatFactory.
$factory = new FormatFactory(); 
$format = $factory->create($formatKey);

// See ProductOutput in raz-lib.php for reference
$output = new ProductOutput();
// ...
$output->format();
