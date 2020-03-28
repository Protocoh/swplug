<?php

namespace ModulesGarden\SWPlug\Repositories;

use \ModulesGarden\SWPlug\Repositories\Repository;

class Client extends Repository
{
    public function getModel()
    {
        return "\\Client";
    }
}
