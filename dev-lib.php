<?php

/**
 * Your code goes here
 */

class FormatFactory
{
    protected $formatKey;
    
    public function create($formatKey){
        $this->formatkey=$formatKey;
        //TODO 
        if ($this->formatKey == 'csv') {
            echo "From dev-lib.php. TODO for csv";

        }

        if ($this->formatKey == 'xml') {
            echo "From dev-lib.php. TODO for xml";

        }

        if ($this->formatKey == 'json') {
            echo "From dev-lib.php. TODO for json";

        }

    }
    
}