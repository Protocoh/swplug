<?php

namespace ModulesGarden\SWPlug\Resources;

class Redirect
{
    public static function to($location, $params = [])
    {
        ob_clean();
        
        $query = "";
        
        if(!empty($params))
        {
            $query = "?".http_build_query($params);
        }
        
        header("Location: ".$location.$query);
        die();
    }
}
