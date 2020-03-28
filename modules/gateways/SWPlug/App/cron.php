<?php

use \ModulesGarden\SWPlug\Registry;
use \ModulesGarden\SWPlug\Resources\CronTaskRegister;

require_once dirname(__DIR__).DIRECTORY_SEPARATOR."Loader.php";

Registry::init();

require_once WHMCS_MAIN_DIR."init.php";

$cronTasksRegister = new CronTaskRegister();

$cronTasksRegister->registerTask("\\ModulesGarden\\SWPlug\\App\\CronTasks\\CheckPayments");

$cronTasksRegister->runTasks();

