<?php

use \WHMCS\ClientArea;
use \ModulesGarden\SWPlug\Registry;
use \ModulesGarden\SWPlug\Resources\Langs;
use \ModulesGarden\SWPlug\Resources\Date;
use \ModulesGarden\SWPlug\Core\Invoice;
use \ModulesGarden\SWPlug\App\Converters\TickerCurrenciesConverter;
use \ModulesGarden\SWPlug\App\SWPlugPaymentGateway;
use \ModulesGarden\SWPlug\App\Mergers\Script;
use \ModulesGarden\SWPlug\App\Validators\SWPlugConfigurationValidator;

require_once __DIR__.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'gateways'.DIRECTORY_SEPARATOR.'SWPlug'.DIRECTORY_SEPARATOR.'Loader.php';

Registry::init();

require_once __DIR__ . '/init.php';

$ca = new ClientArea();

initialiseClientArea("SWPlug", "SWPlug", "", "", "");

try
{
    if(!isset($_SESSION['uid']) || empty($_SESSION['uid']))
    {
        throw new \Exception("You have no access to this page");
    }
    
    try
    {
        if(isset($_POST['invoiceid']))
        {   
            $invoice = new Invoice($_POST['invoiceid']);
            $invoice->date = Date::toWhmcsFormat($invoice->date);
    
            if($invoice->user->id != $_SESSION['uid'])
            {
                throw new \Exception("You have no access to invoice #{$invoice->id}");
            }

            $swPlugPaymentGateway = new SWPlugPaymentGateway();
            $gatewayConfiguration = $swPlugPaymentGateway->getConfiguration();

            $validator = new SWPlugConfigurationValidator($gatewayConfiguration);
            if(!$validator->validate())
            {
                throw new \Exception($validator->getErrors());
            }

            $converter = new TickerCurrenciesConverter($invoice->user->currency->code);
            $xlmAmount = $converter->convertToXlm($invoice->countBalance());

            $stellarData = [
                'amount' => $xlmAmount,
                'memo' => substr(md5($invoice->id.$_SESSION['uid']), 0, 28),
                'wallet' => $gatewayConfiguration['stellarAddress']
            ];

            $script = new Script("swplug.js");

            $scriptParams = [
                'memo' => substr(md5($invoice->id.$_SESSION['uid']),0, 28),
                'invoiceid' => $invoice->id,
                'returnurl' => $_POST['returnurl'],
                'wallet' => $gatewayConfiguration['stellarAddress']
            ];

            $langs = new Langs();
            $langFilePath = GATEWAYS_MAIN_DIR.DS."SWPlug".DS."App".DS."langs.php";

            $smarty->assign("langs", $langs->load($langFilePath));
            $smarty->assign("invoice", $invoice);
            $smarty->assign("stellarData", $stellarData);
            $smarty->assign("script", $script->merge($scriptParams));
        }
        else
        {
            throw new \Exception("Unknown invoice ID");
        }
    }
    catch(\Exception $e)
    {
        $smarty->assign("error", $e->getMessage());
        $smarty->assign("invoiceid", $_POST['invoiceid']);
    }
} 
catch (\Exception $e) 
{
    $smarty->assign("error", $e->getMessage());
}

outputClientArea("SWPlug", false);