<?php

namespace ModulesGarden\SWPlug\Libs\Interfaces;

interface PaymentGateway
{
    public function getMetaData();
    public function getConfigurationFields();
}
