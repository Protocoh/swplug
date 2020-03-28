<?php

namespace ModulesGarden\SWPlug\Core;

use \ModulesGarden\SWPlug\Repositories\Transaction as TransactionRepository;

class Transaction
{
    public $id;
    public $gateway;
    public $date;
    public $amountin;
    public $amountout;
    public $transactionid;
    public $refundid;
    
    public function __construct($id)
    {
        $transactionRepository = new TransactionRepository();
        $transaction = $transactionRepository->getById($id);
        
        $this->id = $transaction->id;
        $this->gateway = $transaction->gateway;
        $this->date = $transaction->date;
        $this->amountin = $transaction->amountin;
        $this->amountout = $transaction->amountout;
        $this->transactionid = $transaction->transid;
        $this->refundid = $transaction->refundid;
    }
}
