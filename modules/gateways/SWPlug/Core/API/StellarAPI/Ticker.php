<?php

namespace ModulesGarden\SWPlug\Core\API\StellarAPI;

use \ModulesGarden\SWPlug\Resources\CURL;
use \ModulesGarden\SWPlug\Core\API\StellarAPI\Ticker\Request\GetCurrencies;

class Ticker extends CURL
{
    protected $endpoint = null;
    
    public function __construct()
    {
        $this->endpoint = "https://stellar.api.stellarport.io";
    }
    
    public function getCurrencies()
    {
        $request = new GetCurrencies();
        $response = $this->send($request);

        return $response;
    }
}
