<?php

namespace ModulesGarden\SWPlug\Core\API;

class Request
{
    public function getApiRequest()
    {
        return $this->apiRequest;
    }
    
    public function getRequestMethod()
    {
        return $this->method;
    }
    
    public function getRequestParams()
    {
        return $this->params;
    }
    
    public function getResponseClass() 
    {
        return $this->responseClass;
    }
}
