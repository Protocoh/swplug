<?php

namespace ModulesGarden\SWPlug\Core;

use \ModulesGarden\SWPlug\Repositories\Client as ClientRepository;
use \ModulesGarden\SWPlug\Core\Currency;

class User
{
    public $id = null;
    public $firstname = null;
    public $lastname = null;
    public $currency = null;
    
    public function __construct($id)
    {
        $clientRepository = new ClientRepository();
        $user = $clientRepository->getById($id);
        
        $this->id = $user->id;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->currency = new Currency($user->currency);
    }
}
