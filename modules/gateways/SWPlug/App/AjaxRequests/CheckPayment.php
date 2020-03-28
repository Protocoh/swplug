<?php

namespace ModulesGarden\SWPlug\App\AjaxRequests;

use \ModulesGarden\SWPlug\Resources\Ajax;
use \ModulesGarden\SWPlug\App\SWPlugPaymentGateway;
use \ModulesGarden\SWPlug\App\StellarPayment;
use \ModulesGarden\SWPlug\Core\Invoice;

class CheckPayment extends Ajax
{
    public function __construct($params = [])
    {
        parent::__construct($params);
    }
    
    public function action($parameters)
    {   
        $invoice = new Invoice($parameters['invoiceid']);
        unset($parameters['invoiceid']);
        
        $swplugPaymentGateway = new SWPlugPaymentGateway();
        
        $payment = new StellarPayment($swplugPaymentGateway);
        $transaction = $payment->searchInPaymentLocator($parameters);

        if($transaction)
        {
            $payment->add($invoice, $transaction);
        }
        
        return ["result" => "success", "transaction" => $transaction];
    }
}
