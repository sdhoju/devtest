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
    protected $format;

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

        $this->format = new Format();

        $this->format->setFormatKey($formatKey);

        // echo "Format Created";
        return $this->format;
    }   
}

/**
 * Format class is the implementation of FormatInterface 
 *
 * Is used to create the format and define the formatProduct
 */
class Format implements FormatInterface{
    /** @var string $formatKey represents the format key to be outputed(csv,xml,json)*/
    protected $formatKey;
    protected $output='';
    protected  $xmlObject;

    public function start(){
        switch ($this->formatKey) {
            
            case 'csv':
                $header = array("sku", "name", "price", "short_description");
                // $header = array("sku", "name");

                $this->output.= "<br><center>";
                $this->output.=  '<table>';
                $this->output.=  '<tr>';
                foreach($header as $th){
                    $this->output.=  '<th>'.$th.'</th>';
                } $this->output.=  '</tr>';
                return   $this->output;

                break;
            case 'xml':
                header('Content-Type: text/xml');
                $this->xmlObject = new myXML('1.0', 'utf-8');
                
                break;
            case 'json':
                header('Content-Type: application/json');


                break;
        }
    }

    /**
     * Clean the format the product according to the formatkey 
     *
     * @param array $product catalogProductEntity 
     * more info in https://devdocs.magento.com/guides/m1x/api/soap/catalog/catalogProduct/catalog_product.list.html
     *
     * @return array $cleanProduct that has only 4 attributes.'sku','name', 'price', 'short_description'
     */
    public function formatProduct(array $product){
        $this->output='';

        $fields  = ['sku','name', 'price', 'short_description'];
        $product=$this->moreInfo($fields,$product);
        
        
        
        switch ($this->formatKey) {
            case 'csv':
                $this->output.= '<tr>';
                $this->output.= '<td>'.$product['sku'].'</td>';
                $this->output.= '<td>'.$product['name'].'</td>';
                $this->output.= '<td>'.$product['price'].'</td>';
                $this->output.= '<td>'.$product['short_description'].'</td>';
                $this->output.= '</tr>';
                return   $this->output;
                break;
            case 'xml':
                // $xmlArray= array(
                //     "product"=>array(
                //         "detail"=>$product
                // ));
                // $this->xmlObject->preserveWhiteSpace = false;
                // $this->xmlObject->formatOutput = true;

                // $this->xmlObject->fromMixed($xmlArray);
                // $this->xmlObject = $this->xmlObject ->saveXML();
                // return $this->xmlObject;
                return "In Progress";
                break;
            case 'json':
                $productJSON =  arrayToJSON($product);
                return $productJSON;
                break;
        }

    }


    public function finish(){
        return "end";
    }

     /**
     * Set the output format key 
     * 
     * @param string $key format of the output 'csv','xml','json'
     */
    public function setFormatKey($key){
        $this->formatKey = $key;
    }


     /**
     * get the information not present in catalogProductEntity
     * 
     * @param array $field array of more fields ['sku','name', 'price', 'short_description']
     * @param array $product catalogProductEntity 
     * more info in https://devdocs.magento.com/guides/m1x/api/soap/catalog/catalogProduct/catalog_product.info.html
     *
     * @return array $cleanProduct that has only 4 attributes.
     */
    public function moreInfo($fields, $product){

        $soap= new Soap();
        $client = $soap->getClient();
        $sessionId = $soap->getSession();
        
        $catalogProductReturnEntity = $client->call($sessionId, 'catalog_product.info', $product['product_id']  );
        
        $cleanProduct = [];
        foreach($fields as $field){
            if(isset($catalogProductReturnEntity[$field])!=null){
                $cleanProduct[$field] = $catalogProductReturnEntity[$field];
            }else
                $cleanProduct[$field] = '';
        }

        return $cleanProduct;

    }
}