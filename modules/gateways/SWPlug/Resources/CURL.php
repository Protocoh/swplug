<?php

namespace ModulesGarden\SWPlug\Resources;

class CURL
{
    private $curlHandle;
    private $query = null;
    private $options = 
    [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_REFERER => 'http://localhost',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
        CURLOPT_HEADER => 0,
        CURLOPT_TIMEOUT => 10
    ];
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }
    
    public function configureConnection()
    {
        foreach($this->options as $name => $setting)
        {
            curl_setopt($this->curlHandle, $name, $setting);
        }
    }
    
    public function send($request)
    { 
        $this->curlHandle = curl_init();

        $this->query = $this->endpoint.$request->getApiRequest();

        $method = $request->getRequestMethod();
        $params = $request->getRequestParams();
        
        $this->{$method}($params);
        $this->options[CURLOPT_URL] = $this->query;

        $this->configureConnection();
        
        $output = curl_exec($this->curlHandle);

        $curlInfo = curl_getinfo($this->curlHandle);

        curl_close($this->curlHandle); 
        
        $responseClass = $request->getResponseClass();
        $response = new $responseClass($output, $curlInfo['http_code']);
        
        return $response;
    }
    
    public function get($params = []) 
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = "GET";
        
        if (!empty($params)) 
        {
            $this->query .= '?'.http_build_query($params);
        }
    }
    
    public function post($params = []) 
    {
        $params = http_build_query($params);
     
        $this->options[CURLOPT_CUSTOMREQUEST] = "POST";
        $this->options[CURLOPT_POSTFIELDS] = $params;
    }
    
    public function __destruct() 
    {     
        curl_close($this->curlHandle); 
    }
}
