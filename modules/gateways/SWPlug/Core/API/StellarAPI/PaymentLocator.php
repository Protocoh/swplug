<?php

namespace ModulesGarden\SWPlug\Core\API\StellarAPI;

use \ModulesGarden\SWPlug\Resources\CURL;
use \ModulesGarden\SWPlug\Core\API\StellarAPI\PaymentLocator\Request\GetPayment;

class PaymentLocator extends CURL
{
    private $configuration = null;
    protected $endpoint = null;
    
    public function __construct($configuration)
    {
        $this->configuration = $configuration;
        $this->endpoint = $this->generateEndpoint();
    }
    
    public function generateEndpoint()
    {
        $endpoint = "https://api.stellar.expert/api/explorer/";
        
        if ($this->configuration['testMode'])
        {
            $endpoint .= "testnet";
        }
        else
        {
            $endpoint .= "public";
        }
        
        return $endpoint;
    }
    
    public function getPayment($params)
    {
        $request = new GetPayment($params);
        $response = $this->send($request);
        
        return $response;
    }
}
