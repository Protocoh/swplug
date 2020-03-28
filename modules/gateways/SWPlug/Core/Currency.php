<?php

namespace ModulesGarden\SWPlug\Core;

use \ModulesGarden\SWPlug\Repositories\Currency as CurrencyRepository;

class Currency
{
    public $id = null;
    public $code = null;
    public $prefix = null;
    public $suffix = null;
    public $default = null;
    
    public function __construct($id)
    {
        $currencyRepository = new CurrencyRepository();
        $currency = $currencyRepository->getById($id);
        
        $this->id = $currency->id;
        $this->code = trim($currency->code);
        $this->prefix = trim($currency->prefix);
        $this->suffix = trim($currency->suffix);
        $this->default = $currency->defult;
    }
}
