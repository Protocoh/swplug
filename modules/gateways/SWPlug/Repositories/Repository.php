<?php

namespace ModulesGarden\SWPlug\Repositories;

use WHMCS\Database\Capsule as Database;

abstract class Repository
{
    private $baseModelPath = "\\ModulesGarden\\SWPlug\\Entities";

    abstract public function getModel();
    
    public function updateOrCreate($match, $values = []) 
    {
        $model = $this->baseModelPath.$this->getModel();
        $result = $model::updateOrCreate($match, $values);
        return $result;
    }
    
    public function create($values = []) 
    {
        
        $modelname = $this->baseModelPath.$this->getModel();
        $model = new $modelname();
        
        foreach($values as $property => $value) {
            $model->{$property} = $value;
        }

        $model->save();
        
        return $model;
    }
    
    public function update($conditions = [], $update = []) 
    {
        $model = $this->baseModelPath.$this->getModel();
        $table = (new $model())->getTable(); 
        
        $query = Database::table($table);
        foreach($conditions as $property => $value) {
            $query->where($property, "=", $value);
        }

        $query->update($update);
    }

    public function getByProperties($properties = []) 
    {
        $model = $this->baseModelPath.$this->getModel();
        $table = (new $model())->getTable();
        
        $query = Database::table($table);
        foreach($properties as $property => $value) {
            $query->where($property, "=", $value);
        }

        return $query;
    }
    
    public function getByMatchedProperty($property, $valuesSet) 
    {
        $model = $this->baseModelPath.$this->getModel();
        $table = (new $model())->getTable();
        
        $query = Database::table($table);
        $query->whereIn($property,$valuesSet);
        return $query;
    }
    
    public function getAll() 
    {
        $model = $this->baseModelPath.$this->getModel();
        $all = $model::all();
        return $all;
    }
    
    public function getFirst() 
    {
        $model = $this->baseModelPath.$this->getModel();
        $first = $model::first();
        return $first;
    }
    
    public function getById($id)
    {
        $model = $this->baseModelPath.$this->getModel();
        $result = $model::find($id);
        
        return $result;
    }
    
    public function hydrate($result)
    {
        $model = $this->baseModelPath.$this->getModel();
        return $model::hydrate($result);
    }
}
