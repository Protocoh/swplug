<?php

namespace ModulesGarden\SWPlug\App;

use \ModulesGarden\SWPlug\Core\API\StellarAPI\PaymentLocator;
use \ModulesGarden\SWPlug\App\Converters\TickerCurrenciesConverter;
use \ModulesGarden\SWPlug\Core\Invoice;
use \ModulesGarden\SWPlug\App\Comparators\PriceComparator;
use \ModulesGarden\SWPlug\App\Validators\SWPlugConfigurationValidator;
use \ModulesGarden\SWPlug\App\StellarTransaction;

require_once WHMCS_MAIN_DIR.DS."includes".DS."invoicefunctions.php";
require_once WHMCS_MAIN_DIR.DS."includes".DS."gatewayfunctions.php";

class StellarPayment
{
    private $gateway = null;
    
    public function __construct($paymentGateway = null)
    {
        $this->gateway = $paymentGateway;
    }
    
    public function searchInPaymentLocator($conditions = [])
    {
        $gatewayConfiguration = $this->gateway->getConfiguration();

        $validator = new SWPlugConfigurationValidator($gatewayConfiguration);
        if(!$validator->validate())
        {
            throw new \Exception($validator->getErrors());
        }
        
        $apiConfiguration = [
            'wallet' => $gatewayConfiguration['stellarAddress'],
            'testMode' => ($gatewayConfiguration['testMode'] == "on")?true:false
        ];

        $api = new PaymentLocator($apiConfiguration);
        $response = $api->getPayment($conditions)->getResponse();

        $stellarTransaction = new StellarTransaction();
        $result = null;
        
        foreach($response->_embedded->records as $transaction)
        {
            $searchResult = $stellarTransaction->searchInWHMCS($transaction);

            if($searchResult)
            {
                continue;
            }

            $result = $transaction;
            break;
        }

        return $result;
    }
    
    public function add(Invoice $invoice, $transaction)
    {
        $gatewayConfiguration = $this->gateway->getConfiguration();

        $validator = new SWPlugConfigurationValidator($gatewayConfiguration);
        if(!$validator->validate())
        {
            throw new \Exception($validator->getErrors());
        }
 
        $invoiceid = checkCbInvoiceID($invoice->id, $gatewayConfiguration['name']);
        
        $converter = new TickerCurrenciesConverter($invoice->user->currency->code);
        $convertedAmount = $converter->convertFromXlm($transaction->amount);
  
        $priceComparator = new PriceComparator();
        $amount = $priceComparator->checkConvertedPrice($invoice->total, $convertedAmount, $gatewayConfiguration['paymentAmountDifference']);

        logTransaction($gatewayConfiguration['name'], "Invoice ID: {$invoice->id}\nAmount: $amount {$invoice->user->currency->code}", "Accepted"); 
        
        addInvoicePayment($invoiceid, $transaction->id, $amount, 0, strtolower($gatewayConfiguration['name']));

        $template = $gatewayConfiguration['paymentConfirmationEmailTemplate']?:"Credit Card Payment Confirmation";
        sendMessage($template, $invoiceid);
    }
}
