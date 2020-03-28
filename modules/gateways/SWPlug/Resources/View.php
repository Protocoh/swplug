<?php

namespace ModulesGarden\SWPlug\Resources;

class View
{
    private $smarty;
    private $templateDir;
    
    public function __construct($templateDir)
    {
        $this->smarty = new \Smarty();
        $this->templateDir = $templateDir;
        $this->smarty->setTemplateDir($this->templateDir);
    }
    
    public function loadTemplate($tplName, $tplVars = [])
    {
        foreach ($tplVars as $name => $value)
        {
            $this->smarty->assign($name, $value);
        }

        $output = $this->smarty->fetch($tplName);

        return $output;
    }
}
