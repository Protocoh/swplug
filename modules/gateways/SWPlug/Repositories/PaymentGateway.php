<?php

namespace ModulesGarden\SWPlug\Repositories;

use \ModulesGarden\SWPlug\Repositories\Repository;

class PaymentGateway extends Repository
{
    public function getModel()
    {
        return "\\PaymentGateway";
    }
}
