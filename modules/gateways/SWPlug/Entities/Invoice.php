<?php

namespace ModulesGarden\SWPlug\Entities;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = 'tblinvoices';
    public $timestamps = false;
    
    public function transactions()
    {
        return $this->hasMany('\\ModulesGarden\\SWPlug\\Entities\\Transaction', "invoiceid", "id");
    }
}
