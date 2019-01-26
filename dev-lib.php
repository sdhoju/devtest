<?php

/**
 * Your code goes here
 */
require_once __DIR__ . '/raz-lib.php';

class FormatFactory
{
    private $formatKey;

    public function create($formatKey){
        $this->formatkey=$formatKey;

        if ($this->formatkey == 'csv') {

            $header = array("sku", "name", "price", "short_description");
            $fp = fopen('outputs/output.csv', 'w');
            fputcsv($fp, $header);
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