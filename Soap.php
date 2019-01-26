<?php 

require_once __DIR__ . '/raz-lib.php';
require_once __DIR__ . '/dev-lib.php';

/**
 * SOAP class for the project.
 *
 * Created to hide the information of server, user and key .
 */
class Soap
{
    private $apiWsdl = 'https://www.shopjuniorgolf.com/api/?wsdl';
    private $apiUser = 'devtest';
    private $apiKey ='ku%64TeYMo5mAIFj8e';

    private $soap;
    private $sessionId;

    /**
     * Initializes soap with SoapClient for given server
     */
    function __construct() {
        $this->soap = new SoapClient($this->apiWsdl);
    }

    /**
     * Provides the initialized soap.
     *
     * @return soap
     */
    function getClient(){
        return $this->soap;
    }

     /**
     * Provides the session after the login to the soap
     *
     * @return sessionId
     */
    function getSession(){
        return $this->soap->login($this->apiUser, $this->apiKey);
    }

}