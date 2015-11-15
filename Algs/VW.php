<?php
namespace TestAlg\Algs;

use TestAlg\Points\PointsService;

class VW
{   
//    private $minimalArea = null;
//    private $minimalAreaKey = null;
//    private $listOfAreas = [0];
    
    public static  function run($points, $countOfPoints)
    {
        $minimalArea = null;
        $minimalAreaKey = null;
        $listOfAreas = [0];
        
        if(count($points)<3)
        {
            return $points;
        }
        
        self::initAreasList($points, $minimalAreaKey, $listOfAreas);
        
        for($i = 0; $i < $countOfPoints; $i++)
        {
            self::removeMinimalTrrianglePoint($points, $minimalAreaKey, $listOfAreas);
        }
        
        return $points;
        
    }
    
    private static  function initAreasList(&$points, &$minimalAreaKey, &$listOfAreas)
    {
        $minimalArea = PointsService::getAreaTriangle($points[0], $points[1], $points[2]);
        $listOfAreas[1] =  $minimalArea;
        $minimalAreaKey = 1;
        
        for(
            $a = 1, $b = 2, $c = 3, $size = count($points); 
            $c < $size; 
            $a++, $b++, $c++
        )
        {
            $listOfAreas[$b] =  PointsService::getAreaTriangle(
                                $points[$a], 
                                $points[$b], 
                                $points[$c]
                            );
            
            if ($minimalArea > $listOfAreas[$b])
            {
                $minimalArea = $listOfAreas[$b];
                $minimalAreaKey = $b;
            }
        }
    }
    
    private static function removeMinimalTrrianglePoint(&$points, &$minimalAreaKey, &$listOfAreas)
    {
        //Recalculate new left triangle 
        if($minimalAreaKey > 1)
        {
            $leftPointKey = $minimalAreaKey - 1;
            $listOfAreas[$leftPointKey] = PointsService::getAreaTriangle(
                                                    $points[$leftPointKey - 1], 
                                                    $points[$leftPointKey], 
                                                    $points[$leftPointKey + 1]
                                                );
        }
        
        //Recalculate new right triangle
        if($minimalAreaKey < count($minimalAreaKey) - 2 )
        {
            $rightPointKey = $minimalAreaKey - 1;
            $listOfAreas[$rightPointKey] = PointsService::getAreaTriangle(
                                                    $points[$rightPointKey - 1], 
                                                    $points[$rightPointKey], 
                                                    $points[$rightPointKey + 1]
                                                );
        }
        //Remove old point and their area of trangle
        unset($points[$minimalAreaKey]);
        unset($listOfAreas[$minimalAreaKey]);
        
        //flush keys
        // TODO: need replace it to more faster logic
        $points = array_values($points);
        $listOfAreas = array_values($listOfAreas);
        
//        print_r($listOfAreas);
        $minimalArea = $listOfAreas[1];
        $minimalAreaKey = 1;
        
        
        for($i = 2, $size = count($listOfAreas); $i < $size; $i++)
        {
            if($minimalArea > $listOfAreas[$i])
            {
                $minimalArea = $listOfAreas[$i];
                $minimalAreaKey = $i;
            }
        }
        
        
    }
    
}