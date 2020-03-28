<?php

namespace ModulesGarden\SWPlug\Resources;

class Merger
{
    protected $basePath;
    protected $filePath;
    protected $fileInfo;
    
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->fileInfo = pathinfo($this->filePath);
    }
    
    public function setFilePath($path = "")
    {
        $this->filePath = $this->basePath.$path;
        $this->fileInfo = pathinfo($this->filePath);
    }
    
    public function merge($variables = [])
    {
        $content = file_get_contents($this->filePath);

        foreach($variables as $name => $value)
        {           
            $content = str_replace("{".$name."}", $value, $content);
        }

        return $this->addHTMLTag($content);
    }
    
    public function addHTMLTag($content)
    {
        switch($this->fileInfo['extension'])
        {
            case 'js': return "<script type='text/javascript'>".$content."</script>";
            case 'css': return "<style>".$content."</style>"; 
            default: return $content;
        }
    }
}
