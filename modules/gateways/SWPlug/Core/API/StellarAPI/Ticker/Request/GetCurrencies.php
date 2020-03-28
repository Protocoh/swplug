<?php

namespace ModulesGarden\SWPlug\Core\API\StellarAPI\Ticker\Request;

use \ModulesGarden\SWPlug\Core\API\Request;

class GetCurrencies extends Request
{
    protected $apiRequest = "/Ticker";
    protected $method = "get";
    protected $params;
    protected $responseClass = '\\ModulesGarden\\SWPlug\\Core\\API\\StellarAPI\\Ticker\\TickerApiResponse';
}
