<?php
namespace TestAlg\Algs;

use TestAlg\Points\PointsService;

class DP
{    
    public static function run($points, $epsilonSquare)
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

        if($keyOfMaxEl !== null && $maxLength > $epsilonSquare)
        {
            $result = self::run(array_slice($points, 0, $keyOfMaxEl + 1), $epsilonSquare);
            $tmpPoints  = self::run(array_slice($points, $keyOfMaxEl), $epsilonSquare);
            foreach ($tmpPoints as $key => $point)
            {
                if($key)
                {
                    array_push($result, $point);
                }
            }

            return $result;
        }

        return [$points[0], $points[count($points)-1]];
    }
    
    public static function runWithoutRecursion($points, $epsilonSquare)
    {
//        $watchdog = 0;
        $stack = [[0, count($points)-1]];
        
        while (!empty($stack))
        {
            //Just for testing mode
//            if(++$watchdog>10000)
//            {
//                break;
//            }
            
            $limits = array_pop($stack);
            
            
            //TODO: Heare  heed check variant if we have 3 points and current 
            //length more than epsilon not need add new diapasons to stack
            if($limits[1] - $limits[0] < 2)
            {
                continue;
            }
            
            $keyOfMaxEl = null;
            $maxLength = 0;
            
            for($i = $limits[0] + 1; $i < $limits[1]; $i++)
            {
                // TODO: Need remove repeating calculation on base line point coordinates
                //possible bad variand becouse same points will happen not very often but comparation happen for all limits
//                if($points[$limits[0]] === $points[$limits[1]])
//                {
//                    //same start and end point can use just distance between 2 points
//                    $curentLength = PointsService::getDistance2Points($points[$i], $points[$limits[0]]);
//                }
//                else
//                {
                    $curentLength = PointsService::minimalLengthToLine($points[$i], $points[$limits[0]], $points[$limits[1]]);
//                }

                if($curentLength > $maxLength)
                {
                    $maxLength = $curentLength;
                    $keyOfMaxEl = $i;
                }
            }
            
            if($keyOfMaxEl !== null && $maxLength > $epsilonSquare)
            {
                // TODO: Need experementis 2 [] will work fater than array_push
//                array_push($stack, [$limits[0], $keyOfMaxEl], [$keyOfMaxEl, $limits[1]]);
                $stack[] = [$limits[0], $keyOfMaxEl];
                $stack[] = [$keyOfMaxEl, $limits[1]];
            }
            else
            {
                
                //TODO:  Need replace to unset It will work ~10% faster. 
                //Maybe not need becouse it will be lot operations exept one function call
                array_splice($points, $limits[0] + 1, $limits[1] - $limits[0] - 1, 0);
                
            }
            

        }
        $result = [];
        
        foreach($points as $point)
        {
            if($point !== 0)
            {
                $result[] = $point;
            }
        }
        
        return $result;
    }
    
}

