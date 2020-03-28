<?php

namespace ModulesGarden\SWPlug\Repositories;

use \ModulesGarden\SWPlug\Repositories\Repository;

class Transaction extends Repository
{
    public function getModel()
    {
        return "\\Transaction";
    }
}
