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
    
    public static function runCrazyOptimization($points, $epsilonSquare)
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
//                    $curentLength = PointsService::minimalLengthToLine($points[$i], $points[$limits[0]], $points[$limits[1]]);
                    if(
                            $points[$limits[0]][1] === 
                            $points[$limits[1]][1]
                    )
                    {
                        $y = $points[$limits[0]][1];
                    }elseif($points[$limits[0]][0] === $points[$limits[1]][0])
                    {
                        $y = $points[$i][1];
                    }
                    else
                    {
                        $y = (
                                (
                                    ($points[$i][0] - $points[$limits[0]][0]) / 
                                    ($points[$limits[1]][0] - $points[$limits[0]][0])
                                ) * 
                                (
                                    $points[$limits[1]][1] - $points[$limits[0]][1]
                                )
                            ) + $points[$limits[0]][1];
                    }
                    
                    $tPointA = [$points[$i][0], $y];  //new Point($point[0], self::getYCoordinateForTriangle($point, $points[$limits[0]], $points[$limits[1]]));

                    if($points[$limits[0]][0] === $points[$limits[1]][0])
                    {
                        $x = $points[$limits[0]][0];
                    }
                    elseif($points[$limits[0]][1] === $points[$limits[1]][1])
                    {
                        $x = $points[$i][0];
                    }
                    else
                    {
                        $x = (
                                (
                                    ($points[$i][1] - $points[$limits[0]][1]) / 
                                    ($points[$limits[1]][1] - $points[$limits[0]][1])
                                ) * 
                                (
                                    $points[$limits[1]][0] - $points[$limits[0]][0]
                                )
                            ) + $points[$limits[0]][0];
                    }
                    
                    $tPointB = [$x,  $points[$i][1]];//new Point(self::getXCoordinateForTriangle($point, $points[$limits[0]], $points[$limits[1]]), $point[1]);

//print_r($tPointA);
                    $aLength = //self::getSquareDistance2Points($tPointA, $tPointB);
                            pow(
                                $tPointA[0] - $tPointB[0],
                                2
                            ) + 
                            pow(
                                $tPointA[1] - $tPointB[1],
                                2
                            );
                    $bLength = //self::getSquareDistance2Points($point, $tPointB);
                            pow(
                                $points[$i][0] - $tPointB[0],
                                2
                            ) + 
                            pow(
                                $points[$i][1] - $tPointB[1],
                                2
                            );
                    $cLength = //self::getSquareDistance2Points($point, $tPointA);
                            pow(
                                $points[$i][0] - $tPointA[0],
                                2
                            ) + 
                            pow(
                                $points[$i][1] - $tPointA[1],
                                2
                            );

                    // for paralel to coordinate lines 
                    if($aLength === $cLength || $aLength === $bLength)
                    {
                        $curentLength =  $aLength;
                    }
                    else
                    {
                        // |\
                        // | \
                        // |  \
                        // |  /\ 90
                        // | /h \
                        // |/____\  alpha
                        //
                        //  sin(alpha) = c / a
                        //  sin(alpha) = h / b
                        //  h = (b * c) / a
                        $curentLength =  ($bLength * $cLength) / $aLength;
                    }
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

