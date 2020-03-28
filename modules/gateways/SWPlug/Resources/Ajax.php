<?php

namespace ModulesGarden\SWPlug\Resources;

abstract class Ajax
{
    private $parameters = null;
    
    public function __construct($params)
    {
        $this->parameters = $params;   
    }
    
    public function execute()
    {
        try 
        {
            $response = $this->action($this->parameters);  
        } 
        catch (\Exception $e) 
        {
            $response = ["result" => "error", "message" => $e->getMessage()];
        }
        finally
        {
            return json_encode($response);
        }
    }
    
    abstract public function action($params);
}
