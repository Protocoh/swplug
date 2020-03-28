<?php

namespace ModulesGarden\SWPlug\App;

use \ModulesGarden\SWPlug\Repositories\Transaction as TransactionRepository;

class StellarTransaction
{
    public function searchInWHMCS($transaction)
    {
        $transactionRepository = new TransactionRepository();
        $whmcsTransaction = $transactionRepository->getByProperties(['transid' => $transaction->id])->first();
        
        if($whmcsTransaction->id)
        {
            return $whmcsTransaction;
        }
        
        return null;
    }
}
