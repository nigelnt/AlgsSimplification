<?php

namespace TestAlg\Points;

use \TestAlg\Points\Point;

class Helper
{
    public static function fromArrayToPoints($src)
    {
        $points = [];
        
        foreach ($src as $point)
        {
            $points[] = new Point($point[0], $point[1]);
        }
        
        return $points;
    }
    
    public static function fromPointsToArray($src)
    {
        $points = [];
        
        foreach ($src as $point)
        {
            $points[] = $point->getCoordinates();
        }
        
        return $points;
    }
    
    public static function multiplicateCoordinatesArray($src, $multiplicator)
    {
        $points = [];
        foreach ($src as $point)
        {
            $points[] = [$point[0]*4, $point[1]*4];
        }
        return $points;
    }
    
    
}
