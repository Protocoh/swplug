<?php

namespace ModulesGarden\SWPlug\Core;

use \ModulesGarden\SWPlug\Repositories\Invoice as InvoiceRepository;
use \ModulesGarden\SWPlug\Core\User;
use \ModulesGarden\SWPlug\Core\Transaction;

class Invoice
{
    public $id = null;
    public $user = null;
    public $date = null;
    public $total = null;
    public $status = null;
    public $paymentmethod = null;
    public $transactions = [];

    public function __construct($id)
    {
        $invoiceRepository = new InvoiceRepository();
        $invoice = $invoiceRepository->getById($id);
  
        $this->id = $invoice->id;
        $this->user = new User($invoice->userid);
        $this->date = $invoice->date;
        $this->total = $invoice->total;
        $this->status = $invoice->status;
        $this->paymentmethod = $invoice->paymentmethod;
     
        foreach($invoice->transactions as $transaction)
        {
            $this->transactions[] = new Transaction($transaction->id);
        }
    }
    
    public function countBalance()
    {
        $balance = $this->total;

        foreach($this->transactions as $transaction)
        {
            if($transaction->refundid != 0)
            {
                $balance += $transaction->amountout;
            }
            else
            {
                $balance -= $transaction->amountin;
            }
        }
        
        return $balance;
    }
    
    public function getTransaction($transId)
    {
        foreach($this->transactions as $transaction)
        {
            if($transaction->transactionid != $transId)
            {
                continue;
            }
            
            return $transaction;
        }
        
        return null;
    }
}
