<?php

namespace ModulesGarden\SWPlug\App\Converters;

use \ModulesGarden\SWPlug\Core\API\StellarAPI\Ticker;

class TickerCurrenciesConverter
{
    const OPEN_RATE = "open";
    const CLOSE_RATE = "close";
    const HIGH_RATE = "high";
    const LOW_RATE = "low";

    private $currency = null;
    private $asset = null;
    private $rateType = null;
    
    public function __construct($currency = "USD", $asset = "XLM", $rate = self::CLOSE_RATE)
    {
        $this->currency = $currency;
        $this->asset = $asset;
        $this->rateType = $rate;
    }
    
    public function loadTickerRates()
    {
        $api = new Ticker();
        $result = $api->getCurrencies()->getResponse();

        return $result->{$this->currency."_".$this->asset};
    }
    
    public function convertToXlm($amount = 0.00)
    {
        $currencyRates = $this->loadTickerRates();

        if(!$currencyRates)
        {
            throw new \Exception("Currency {$this->currency} is not supported by SWPlug payment gateway");
        }
 
        $rate = $currencyRates->{$this->rateType};
        
        return number_format($amount * $rate, 7);
    }
    
    public function convertFromXlm($amount = 0.00)
    {
        $currencyRates = $this->loadTickerRates();
        
        if(!$currencyRates)
        {
            throw new \Exception("Currency {$this->currency} is not supported by SWPlug payment gateway");
        }
        
        $rate = $currencyRates->{$this->rateType};
        
        return number_format($amount / $rate, 2);
    }
}
