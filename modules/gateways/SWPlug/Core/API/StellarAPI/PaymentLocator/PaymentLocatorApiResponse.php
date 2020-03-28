<?php

namespace ModulesGarden\SWPlug\Core\API\StellarAPI\PaymentLocator;

use \ModulesGarden\SWPlug\Core\API\Response;

class PaymentLocatorApiResponse extends Response
{
    public function __construct($response, $code)
    {
        parent::__construct($response, $code);
        
        $this->response = json_decode($response);
         
        if (json_last_error() != "0") 
        {
            throw new \Exception("Response format is not proper");
        }  
        
        if(property_exists($this->response, "error"))
        {
            throw new \Exception($this->response->error);
        }
    }
}
