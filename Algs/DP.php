<?php
namespace TestAlg\Algs;

use TestAlg\Points\PointsService;

class DP
{    
    public static function run($points, $epsilon)
    {
        //Need remove recursion and change it to loop
        
        $keyOfMaxEl = null;
        $maxLength = 0;
        foreach($points as $key => $point)
        {
            if($key === 0 || $key === count($points)-1)
            {
                continue;
            }

            $curentLength = PointsService::minimalLengthToLine($point, $points[0], $points[count($points)-1]);

            if($curentLength > $maxLength)
            {
                $maxLength = $curentLength;
                $keyOfMaxEl = $key;
            }
        }

        if($keyOfMaxEl !== null && $maxLength > $epsilon)
        {
            $result = self::run(array_slice($points, 0, $keyOfMaxEl + 1), $epsilon);
            $tmpPoints  = self::run(array_slice($points, $keyOfMaxEl), $epsilon);
            foreach ($tmpPoints as $point)
            {
                array_push($result, $point);
            }

            return $result;
        }

        return [$points[0], $points[count($points)-1]];
    }
    
    public static function runWithoutRecursion($points, $epsilon)
    {
        $watchdog = 0;
        $stack = [[0, count($points)-1]];
//        echo '<pre>';
        while (!empty($points))
        {
            if(++$watchdog>1000)
            {
                break;
            }
            $limits = array_pop($stack);
            if($limits[1] - $limits[0] < 2)
            {
                continue;
            }
//            print_r($limits);
            $keyOfMaxEl = null;
            $maxLength = 0;
            
            for($i = $limits[0] + 1; $i < $limits[1]; $i++)
            {
                $curentLength = PointsService::minimalLengthToLine($points[$i], $points[$limits[0]], $points[$limits[1]]);

                if($curentLength > $maxLength)
                {
                    $maxLength = $curentLength;
                    $keyOfMaxEl = $i;
                }
            }
            
            if($keyOfMaxEl !== null && $maxLength > $epsilon)
            {
                array_push($stack, [$limits[0], $keyOfMaxEl], [$keyOfMaxEl, $limits[1]]);
            }
            else
            {
//                echo '<pre>';
//                
//                print_r($stack);
//                
//                print_r([$limits[0]+1, $limits[1] - $limits[0] - 1]);
//                
//                print_r([$limits[0] , $limits[1]]);
                
                array_splice($points, $limits[0] + 1, $limits[1] - $limits[0] - 1, 0);
                
//                print_r($points);
//                
//                echo '</pre>';die();
            }
            
//            die();
        }
//        echo '</pre>';
        
        $result = [];
        
        foreach($points as $point)
        {
            if($point !== 0)
            {
                $resultp[] = $point;
            }
        }
        
        return $result;
    }
    
}

