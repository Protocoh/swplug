<?php

namespace ModulesGarden\SWPlug\App\Comparators;

class PriceComparator
{
    public function checkConvertedPrice($originalAmount, $convertedAmount, $allowedDifference = 5)
    {
        $difference = $convertedAmount - $originalAmount;

        $percentage = (abs($difference) / $originalAmount) * 100;
        
        if($percentage <= $allowedDifference)
        {
            $price = $originalAmount;
        }
        else
        {
            $price = $convertedAmount;
        }
        
        return $price;
    }
}
