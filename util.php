<?php


 /**
 * "Converts" the PHP array object into Json format Returns the JSON representation of a value
 * functionality like  http://php.net/manual/en/function.json-encode.php
 * 
 * @param array $products  
 *
 * @return object $jsonObj JSON representation of a value
 */
function arrayToJSON($products){
    if (is_string($products)) return '"'.addslashes($products).'"';
    if (is_numeric($products)) return $products;
    if ($products === null) return 'null';
    if ($products === true) return 'true';
    if ($products === false) return 'false';
    $assoc = false;
    $i = 0;
    
    foreach ($products as $index=>$productArray){
        if ($index !== $i++){
            $assoc = true;
            break;
        }
    }
    
    $product = [];
    foreach ($products as $index=>$productArray){
        $productArray = arrayToJSON($productArray);
        if ($assoc){
            $index = '"'.addslashes($index).'"';
            $productArray = $index.':'.$productArray;
        }
        $product[] = $productArray;
    }
    
    $product = implode(',', $product);
    $jsonObj= ($assoc)? '{'.$product.'}' : '['.$product.']';
    
    return $jsonObj;
}