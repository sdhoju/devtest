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
class FormatFactory extends ProductOutput 
{

    /** @var string $formatKey represents the format key to be outputed(csv,xml,json)*/
    protected $formatKey;


    /**
     * Creates the output of products in requested format 
     *
     * @param string $formatKey is the requested format key(csv,xml,json)
     *     
     * @param bool $toDownload (Optional) is the toggle to download the output files
     * 
     * @return Format format is the implementation of Formatinterface
     */
    public function create($formatKey, $toDownload=false){

        $this->format = new Format();

        $this->formatkey=$formatKey;
        
        $maxProduct=10;
        $maxProduct=count($this->products);

        $cleanProducts=[];
        for($i=0; $i<$maxProduct; $i++) {
            $product = $this->products[$i];
            $cleanProducts[]=$this->format->formatProduct($product);
        }

        if ($this->formatkey == 'csv') {

            //Add header to CSV file
            $header = array("sku", "name", "price", "short_description");
            echo "<br><center>";
            echo '<table>';
            echo '<tr>';
            foreach($header as $th){
                echo '<th>'.$th.'</th>';
            } echo '</tr>';
            
            foreach($cleanProducts as $product){
                echo '<tr>';
                    echo '<td>'.$product['sku'].'</td>';
                    echo '<td>'.$product['name'].'</td>';
                    echo '<td>'.$product['price'].'</td>';
                    echo '<td>'.$product['short_description'].'</td>';
                echo '</tr>';
            } 
            echo '</table>';
            echo "</center>";
            if($toDownload){
                $fp = fopen('output/output.csv', 'w');
                fputcsv($fp, $header);
                foreach($cleanProducts as $cleanProduct){
                    fputcsv($fp, array_values($cleanProduct));
                }
                fclose($fp);
            }
        
        }

        if ($formatKey == 'xml') {
            
            $xmlArray= array(
                "products"=>array(
                    "product"=>$cleanProducts
            ));
            header('Content-Type: text/xml');
            $xmlObject = new myXML('1.0', 'utf-8');
            $xmlObject->preserveWhiteSpace = false;
            $xmlObject->formatOutput = true;

            $xmlObject->fromMixed($xmlArray);
            $xmlObject = $xmlObject ->saveXML();
            echo $xmlObject;

            if($toDownload){
                $fp = fopen('output/output.xml', 'w');
                fwrite($fp, $xmlObject);
                fclose($fp);
            }
        }

        if ($formatKey == 'json') {

            $cleanProducts=[];
            for($i=0; $i<$maxProduct; $i++) {
                $product = $this->products[$i];
                $cleanProducts[]=$this->format->formatProduct($product);
            }
            header('Content-Type: application/json');
            $productJSON =  arrayToJSON($cleanProducts);
            echo $productJSON;

            if($toDownload){
                $fp = fopen('output/output.json', 'w');
                fwrite($fp, $productJSON);
                fclose($fp);
            }
        }
        return $this->format;
    }   
}

/**
 * Format class is the implementation of FormatInterface 
 *
 * Is used to create the format and define the formatProduct
 */
class Format implements FormatInterface{
    public function start(){
    }

    /**
     * Clean the products from 
     *
     * @param array $product catalogProductEntity 
     * more info in https://devdocs.magento.com/guides/m1x/api/soap/catalog/catalogProduct/catalog_product.list.html
     *
     * @return array $cleanProduct that has only 4 attributes.'sku','name', 'price', 'short_description'
     */
    public function formatProduct(array $product){
        $soap= new Soap();
        $client = $soap->getClient();
        $sessionId = $soap->getSession();
        
        $catalogProductReturnEntity = $client->call($sessionId, 'catalog_product.info', $product['product_id']  );
        
        $cleanProduct = [];
        $cleanProduct['sku']=$product['sku'];
        $cleanProduct['name']=$product['name'];
        // $cleanProduct['price'] = $catalogProductReturnEntity['price'];
        // $cleanProduct['short_description'] = $catalogProductReturnEntity['short_description'];

        $fields  = [ 'price', 'short_description'];
        foreach($fields as $field){
            if(isset($catalogProductReturnEntity[$field])!=null){
                $cleanProduct[$field] = $catalogProductReturnEntity[$field];
            }
        }
        return $cleanProduct;
    }


    public function finish(){
    }
}