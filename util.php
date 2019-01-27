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
    
    $product = implode(",\n\t", $product);
    $jsonObj= ($assoc)? "\n\t{".$product."}" : "[".$product."\n]";

    return $jsonObj;
}


 /**
 * Extends the DOMDocument to implement Create XML
 *
 * Referecnce https://www.devexp.eu/2009/04/11/php-domdocument-convert-array-to-xml/
 */
class myXML extends DOMDocument {

	/**
	 * Constructs elements and texts from an array or string.
	 * The array can contain an element's name in the index part
	 * and an element's text in the value part.
     * 
	 * @param mixed $mixed An array or string.
	 * 
	 * @param DOMElement[optional] $domElement Then element
	 * from where the array will be construct to.
	 * 
	 */
	public function fromMixed($productsArray, DOMElement $domElement = null) {

		$domElement = is_null($domElement) ? $this : $domElement;

		if (is_array($productsArray)) {
			foreach( $productsArray as $index => $products ) {

				if ( is_int($index) ) {
					if ( $index == 0 ) {
						$product = $domElement;
					} else {
						$product = $this->createElement($domElement->tagName);
						$domElement->parentNode->appendChild($product);
					}
				} 
				
				else {
					$product = $this->createElement($index);
					$domElement->appendChild($product);
				}
				
				$this->fromMixed($products, $product);
				
			}
		} else {
			$domElement->appendChild($this->createTextNode($productsArray));
		}
		
	}
	
}