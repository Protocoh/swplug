<?php

namespace ModulesGarden\SWPlug\Resources;

class CronTaskRegister
{
    private $tasks = [];
    
    public function registerTask($name)
    {
        if(in_array($name, $this->tasks))
        {
            throw new \Exception("Task '$name' is already registered");
        }
        
        $this->tasks[] = $name;
    }
    
    public function runTasks()
    {
        foreach($this->tasks as $taskClass)
        {         
            if(!class_exists($taskClass))
            {
                logActivity("SWPlug Payment Gateway | Action: Running Cron Tasks | Error: Class '$taskClass' does not exist");
                logModuleCall("SWPlug Payment Gateway", "Running Cron Tasks", "", "Class '$taskClass' does not exist", "", "");
            }
            
            $task = new $taskClass();
            $task->run();
        }
    }
}
