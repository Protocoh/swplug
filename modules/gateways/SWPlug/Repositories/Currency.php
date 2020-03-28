<?php

namespace ModulesGarden\SWPlug\Repositories;

use \ModulesGarden\SWPlug\Repositories\Repository;

class Currency extends Repository
{
    public function getModel()
    {
        return "\\Currency";
    }
}
