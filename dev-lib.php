<?php

/**
 * Your code goes here
 */
require_once __DIR__ . '/raz-lib.php';

class FormatFactory extends ProductOutput
{
    protected $formatKey;
    
    public function create($formatKey){

        $this->formatkey=$formatKey;

        if ($this->formatkey == 'csv') {
            //Add header to CSV file
            $header = array("sku", "name", "price", "short_description");
            $fp = fopen('outputs/output.csv', 'w');
            fputcsv($fp, $header);
            foreach ($this->products as $product) {
                fputcsv($fp, $product);  
            }
            fclose($fp);
        
        }

        if ($this->formatKey == 'xml') {
            echo "From dev-lib.php. TODO for xml";

        }

        if ($this->formatKey == 'json') {
            echo "From dev-lib.php. TODO for json";

        }

    }
    
}