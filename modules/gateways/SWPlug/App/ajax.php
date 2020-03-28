<?php

use \ModulesGarden\SWPlug\Registry;

require_once dirname(__DIR__).DIRECTORY_SEPARATOR."Loader.php";

Registry::init();

require_once WHMCS_MAIN_DIR."init.php";

$requestName = $_POST['request'];
$requestParams = $_POST['parameters'];

$ajaxRequestsNamespace = '\\ModulesGarden\\SWPlug\\App\\AjaxRequests\\';
$request = $ajaxRequestsNamespace.$requestName;

$ajaxRequest = new $request($requestParams);
$response = $ajaxRequest->execute();

echo $response;

