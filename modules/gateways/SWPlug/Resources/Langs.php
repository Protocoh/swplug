<?php

namespace ModulesGarden\SWPlug\Resources;

class Langs
{
    public function load($langFilePath)
    {
        $langs = require_once $langFilePath;
        
        return $langs;
    }
}
