<?php 

require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/dev-lib.php';

class Soap
{
    private $apiWsdl = 'https://www.shopjuniorgolf.com/api/?wsdl';
    private $apiUser = 'devtest';
    private $apiKey ='ku%64TeYMo5mAIFj8e';

    private $soap;
    private $sessionId;

    function __construct() {
        $this->soap = new SoapClient($this->apiWsdl);
    }


    function getClient(){
        return $this->soap;
    }

    function getSession(){
        return $this->soap->login($this->apiUser, $this->apiKey);
    }

}