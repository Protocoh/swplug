<?php

namespace ModulesGarden\SWPlug\Resources;

class Date
{
    public static function toWhmcsFormat($date)
    {
        return fromMySQLDate($date);
    }
}
