<?php

namespace ModulesGarden\SWPlug\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    public $table = 'tblpaymentgateways';
    public $timestamps = false;
}
