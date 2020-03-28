<?php

namespace ModulesGarden\SWPlug\App\Validators;

class SWPlugConfigurationValidator
{    
    private $input = null;
    private $errors = [];
    
    public function __construct($gatewayConfiguration)
    {
        $this->input = $gatewayConfiguration;
    }
    
    public function validate()
    {
        if (empty($this->input['stellarAddress']) || preg_match('/^\s{1,}$/', $this->input['stellarAddress']))
        {
            $this->errors[] = "Missing 'Stellar Address' in gateway configuration";
        }

        if (($this->input['paymentAmountDifference'] == "") || preg_match('/^\s{1,}$/', $this->input['paymentAmountDifference']))
        {
            $this->errors[] = "Missing 'Payment Amount Allowed Difference' in gateway configuration";
        }
        else if(!preg_match('/^\d+$/', $this->input['paymentAmountDifference']))
        {
            $this->errors[] = "Incorrect value in 'Payment Amount Allowed Difference' field";
        }
        
        return (count($this->errors) > 0)?false:true;
    }
    
    public function getErrors()
    {
        $errorMessage = "";

        foreach($this->errors as $error)
        {
            $errorMessage .= "<p>$error</p>";
        }

        return $errorMessage;
    }
}
