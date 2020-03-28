<?php

namespace ModulesGarden\SWPlug\App;

use \ModulesGarden\SWPlug\Libs\Interfaces\PaymentGateway;
use \ModulesGarden\SWPlug\Repositories\PaymentGateway as PaymentGatewayRepository;
use \ModulesGarden\SWPlug\Repositories\EmailTemplate as EmailTemplateRepository;

class SWPlugPaymentGateway implements PaymentGateway
{
    private $configuration = null;
    
    public function __construct()
    {
        $paymentGatewayRepository = new PaymentGatewayRepository();
        $this->configuration = $paymentGatewayRepository->getByProperties(["gateway" => "SWPlug"])->pluck("value", "setting");
    }
    
    public function getMetaData()
    {
        return [
            'DisplayName' => 'SWPlug Gateway Module',
            'APIVersion' => '1.0'
        ];
    }
    
    public function getConfigurationFields()
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $invoiceTemplates = $emailTemplateRepository->getByProperties(["type" => "invoice"])->pluck("name", "name");

        return [
            'FriendlyName' => [
                'Type' => 'System',
                'Value' => 'SWPlug',
            ],
            'stellarAddress' => [
                'FriendlyName' => 'Stellar Address',
                'Type' => 'text',
                'Size' => '25'
            ],
            'testMode' => [
                'FriendlyName' => 'Test Mode',
                'Type' => 'yesno'
            ],
            'paymentAmountDifference' => [
                'FriendlyName' => 'Payment Amount Allowed Difference',
                'Type' => 'text',
                'Size' => '25',
                'Description' => "Percentage value of allowed difference between original invoice total and amount obtained at the moment of making payment",
                'Default' => 5
            ],
            'paymentConfirmationEmailTemplate' => [
                'FriendlyName' => 'Payment Confirmation Email Template',
                'Type' => 'dropdown',
                'Size' => '25',
                'Options' => $invoiceTemplates,
                'Description' => "Name of email template which will be sent to client after making payment"
            ]
        ];
    }
    
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
