<?php

namespace ModulesGarden\SWPlug\Repositories;

use \ModulesGarden\SWPlug\Repositories\Repository;

class EmailTemplate extends Repository
{
    public function getModel()
    {
        return "\\EmailTemplate";
    }
}
