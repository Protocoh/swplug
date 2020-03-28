<?php

namespace ModulesGarden\SWPlug\Resources;

class Url
{
    public static function format($url)
    {
        return trim($url, "/");
    }
}
