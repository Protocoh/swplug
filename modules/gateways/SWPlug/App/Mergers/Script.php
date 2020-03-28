<?php

namespace ModulesGarden\SWPlug\App\Mergers;

use \ModulesGarden\SWPlug\Resources\Merger;

class Script extends Merger
{
    private $scriptPath = GATEWAY_ASSETS_DIR."/Js/";

    public function __construct($scriptname)
    {
        parent::__construct($this->scriptPath.$scriptname);
    }
}
