<?php

namespace TestAlg;

use \TestAlg\Points\Helper as PointsHelper;
use \TestAlg\Image\Image;
use \TestAlg\Algs\DP;
use \TestAlg\Algs\VW;

include 'conf.php';

$src = [[14,111],[18,114],[22,110],[25,106],[30,106],[37,108],[44,112],[48,115],[56,118],[57,195],[61,118],[69,119],[73,120],[82,120],[83,117],[88,113],[90,47],[92,112],[99,115],[104,114],[111,110],[113,101],[111,91],[112,84],[115,80],[190,77],[116,75],[117,67],[120,64],[117,56],[116,53],[115,46],[114,37],[110,31],[10,27],[56,22],[74,25],[89,22],[91,13],[107,22],[110,26],[115,21],[117,14]];

$src_array = PointsHelper::multiplicateCoordinatesArray($src, 4);
$src_points = PointsHelper::fromArrayToPoints($src_array);

$image = new Image();
//for($i = 1; $i < 100000; $i +=$i)
$start = microtime(true);
for($i = 1; $i < 100; $i+=0.04)
{
//	$DP =  DP::runWithoutRecursion($src_points, $i);
        $DP = DP::runCrazyOptimization($src_array, $i);
//	
//	$DP =  DP::run($src_points, $i);
//	$image->addPoints($DP, $i);	
}     

echo microtime(true) - $start;
//echo '<pre>';
//print_r($image);
////echo '</pre>';
//$image->addPoints($src_array, Image::BLUE);
//$image->printImage();


