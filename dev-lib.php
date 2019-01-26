<?php

/**
 * Your code goes here
 */
require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/export.php';
require_once __DIR__ . '/Soap.php';


class FormatFactory extends ProductOutput implements FormatInterface
{
    protected $formatKey;
    protected $product;


    public function start(){
        echo "Start";
    }

    public function formatProduct(array $product){
        $soap= new Soap();
        $client = $soap->getClient();
        $sessionId = $soap->getSession();
        
        $fields  = ['sku','name', 'price', 'short_description'];
        $catalogProductReturnEntity = $client->call($sessionId, 'catalog_product.info', $product['product_id']  );
        $cleanProduct = [];
        foreach($fields as $field){
            if(isset($catalogProductReturnEntity[$field])!=null){
                $cleanProduct[$field] = $catalogProductReturnEntity[$field];
            }
        }
        return $cleanProduct;
    }


    public function finish(){
        echo "Finish";
    }

    public function create($formatKey){

        $this->start();
        $this->formatkey=$formatKey;
        if ($this->formatkey == 'csv') {

            $maxProduct=5;
            //Add header to CSV file
            $header = array("sku", "name", "price", "short_description");
            $fp = fopen('outputs/output.csv', 'w');
            fputcsv($fp, $header);

            for($i=0; $i<$maxProduct; $i++) {
                $product = $this->products[$i];
                $cleanProduct=$this->formatProduct($product);
                $onlyValues = array_values($cleanProduct);
                fputcsv($fp, $onlyValues);
            }
            fclose($fp);
        
        }

        if ($this->formatKey == 'xml') {
            echo "From dev-lib.php. TODO for xml";

        }

        if ($this->formatKey == 'json') {
            echo "From dev-lib.php. TODO for json";

        }

        $this->formatProduct($product);
        $this->finish();

    }
    
}