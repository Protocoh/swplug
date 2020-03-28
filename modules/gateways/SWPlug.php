<?php

use \ModulesGarden\SWPlug\App\SWPlugPaymentGateway;
use \ModulesGarden\SWPlug\Resources\View;
use \ModulesGarden\SWPlug\Resources\Url;
use \ModulesGarden\SWPlug\Registry;

require_once 'SWPlug'.DIRECTORY_SEPARATOR."Loader.php";

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

Registry::init();

function SWPlug_MetaData()
{
    $swPlug = new SWPlugPaymentGateway();
    return $swPlug->getMetaData();
}

function SWPlug_config()
{
    $swPlug = new SWPlugPaymentGateway();
    return $swPlug->getConfigurationFields();
}

function SWPlug_link($params)
{
    $tplParams = [
        'action' => Url::format($params['systemurl']).DS."SWPlug.php",
        'returnurl' => $params['returnurl'],
        'invoiceid' => $params['invoiceid'],
        'description' => $params['description'],
        'amount' => $params['amount'],
        'currency' => $params['currency'],
        'paynowlang' => $params['langpaynow']
    ];
    
    $templateDir = GATEWAYS_MAIN_DIR.DS."SWPlug".DS."App".DS."Assets".DS."Templates".DS;
    $view = new View($templateDir);
    $template = $view->loadTemplate("payment_form.tpl", $tplParams);
    return $template;             
}
