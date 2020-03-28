<?php

namespace ModulesGarden\SWPlug\Core\API;

class Response
{
    protected $response;
    protected $code;
    
    public function __construct($response, $code)
    {
        if($response === false) 
        {
            throw new \Exception("API connection error");
        }

        $this->code = $code;
    }
    
    public function getResponse() 
    { 
        return $this->response;
    }
    
    public function getCode() 
    { 
        return $this->code;
    }
}
