<?php

/**
 * Your code goes here
 */
require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/export.php';
require_once __DIR__ . '/Soap.php';
require_once __DIR__ . '/util.php';


/**
 * FormatFactory class 
 *
 * Is used to create the format and output for the project.
 */
class FormatFactory
{

    /**
     * Creates the output of products in requested format 
     *
     * @param string $formatKey is the requested format key(csv,xml,json)
     *     
     * @param bool $toDownload (Optional) is the toggle to download the output files
     * 
     * @return Format format is the implementation of Formatinterface
     */

    public function create($formatKey){
        switch ($formatKey) {
            case 'csv':          
                return   new CSV();
                break;

            case 'xml':
                return new XML();
                break;

            case 'json':
                return new JSON();
                break;
        }   
    }
}

/**
 * Format class is the implementation of FormatInterface 
 *
 * Is used to create the format and define the formatProduct
 */
class CSV implements FormatInterface{


    public function start(){
        $header = array("sku", "name", "price", "short_description");
        $output= "<br><center>";
        $output.=  '<table>';
        $output.=  '<tr>';
        foreach($header as $th){
            $output.=  '<th>'.$th.'</th>';
        } $output.=  '</tr>';
        return   $output;
    }

    public function formatProduct(array $product){
        $fields  = ['sku','name', 'price', 'short_description'];
        $product=moreInfo($fields,$product);

        $output= '<tr>';
        $output.= '<td>'.$product['sku'].'</td>';
        $output.= '<td>'.$product['name'].'</td>';
        $output.= '<td>'.$product['price'].'</td>';
        $output.= '<td>'.$product['short_description'].'</td>';
        $output.= '</tr>';
        return   $output;
    }

    public function finish(){

    }
}


/**
 * XML class is the implementation of FormatInterface 
 *
 * Is used to create the format and define the formatProduct
 */
class XML implements FormatInterface{


    public function start(){
        header('Content-Type: text/xml');
        $xml='<?xml version="1.0" encoding="utf-8"?>
        <products>
        ';
        return $xml;
    }

    public function formatProduct(array $product){
        $fields  = ['sku','name', 'price', 'short_description'];
        $product=moreInfo($fields,$product);

        $xml =arrayToXML($product);
        return $xml;
    }

    public function finish(){
        $xml='</products>';
        return $xml;
    }
}


/**
 * JSON class is the implementation of FormatInterface 
 *
 * Is used to create the format and define the formatProduct
 */
class JSON implements FormatInterface{

    public function start(){
        header('Content-Type: application/json');

    }

    public function formatProduct(array $product){
        $fields  = ['sku','name', 'price', 'short_description'];
        $product=moreInfo($fields,$product);

        $productJSON =  arrayToJSON($product);
        return $productJSON;
    }

    public function finish(){

    }
}