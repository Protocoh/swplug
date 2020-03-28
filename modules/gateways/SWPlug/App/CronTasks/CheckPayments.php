<?php

namespace ModulesGarden\SWPlug\App\CronTasks;

use \ModulesGarden\SWPlug\Libs\Interfaces\CronTask;
use \ModulesGarden\SWPlug\Repositories\Invoice as InvoiceRepository;
use \ModulesGarden\SWPlug\Core\Invoice;
use \ModulesGarden\SWPlug\App\SWPlugPaymentGateway;
use \ModulesGarden\SWPlug\App\StellarPayment;

class CheckPayments implements CronTask
{   
    public function run()
    {
        $invoiceRepository = new InvoiceRepository();
        $unpaidInvoices = $invoiceRepository->getByProperties(["status" => "Unpaid"])->get();
        
        $swplugPaymentGateway = new SWPlugPaymentGateway();
        
        $parameters = ["account" => $swplugPaymentGateway->getConfiguration()['stellarAddress']];
        $payment = new StellarPayment($swplugPaymentGateway);
        
        foreach($unpaidInvoices as $unpaidInvoice)
        {
            try
            {
                $parameters["memo"] = substr(md5($unpaidInvoice->id.$unpaidInvoice->userid), 0, 28);

                $transaction = $payment->searchInPaymentLocator($parameters);

                if($transaction)
                {
                    $invoice = new Invoice($unpaidInvoice->id);
                    $payment->add($invoice, $transaction);
                }
            }
            catch(\Exception $e)
            {
                logActivity("SWPlug Payment Gateway | Action: Running Cron Tasks | Invoice ID: {$unpaidInvoice->id} | Error: {$e->getMessage}");
                logModuleCall("SWPlug Payment Gateway", "Running Cron Tasks", "Invoice ID: {$unpaidInvoice->id}", $e->getMessage(), "", "");
            }
        }
    }
}
