<?php

namespace ModulesGarden\SWPlug\Core\API\StellarAPI\PaymentLocator\Request;

use \ModulesGarden\SWPlug\Core\API\Request;

class GetPayment extends Request
{
    protected $apiRequest = "/payments";
    protected $method = "get";
    protected $params;
    protected $responseClass = '\\ModulesGarden\\SWPlug\\Core\\API\\StellarAPI\\PaymentLocator\\PaymentLocatorApiResponse';
    
    public function __construct($params = [])
    {
        $this->params = $params;
    }
}
