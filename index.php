<?php

namespace TestAlg;

use \TestAlg\Points\Helper as PointsHelper;
use \TestAlg\Image\Image;
use \TestAlg\Algs\DP;
use \TestAlg\Algs\VW;

include 'conf.php';
//[[width,height],....]

$src0 = [[92,158],[80,158],[69,153],[67,147],[64,136],[63,131],[66,126],[70,124],[75,120],[77,118],[84,114],[96,109],[103,105],[104,101],[103,96],[98,92],[91,92],[83,91],[67,91],[59,89],[55,88],[49,83],[43,79],[43,74],[47,66],[55,63],[61,62],[71,64],[82,68],[93,70],[105,73],[111,66],[112,59],[118,55],[127,55],[129,64],[132,74],[136,77],[147,66],[154,41],[166,84],[169,52],[174,64],[178,56],[183,57],[152,13],[15,27],[70,37],[123,23],[91,52],[84,48],[78,55],[70,50],[65,54],[57,52],[27,74]];
$src1 = [[14,111],[18,114],[22,110],[25,106],[30,106],[37,108],[44,112],[48,115],[56,118],[57,195],[61,118],[69,119],[73,120],[82,120],[83,117],[88,113],[90,47],[92,112],[99,115],[104,114],[111,110],[113,101],[111,91],[112,84],[115,80],[190,77],[116,75],[117,67],[120,64],[117,56],[116,53],[115,46],[114,37],[110,31],[10,27],[56,22],[74,25],[89,22],[91,13],[107,22],[110,26],[115,21],[117,14]];
$src2 = [[24,173],[26,170],[24,166],[27,162],[37,161],[45,157],[48,152],[46,143],[40,140],[34,137],[26,134],[24,130],[24,125],[28,121],[36,118],[46,117],[63,121],[76,125],[82,120],[86,111],[88,103],[90,91],[95,87],[107,89],[107,104],[106,117],[109,129],[119,131],[131,131],[139,134],[138,143],[131,152],[119,154],[111,149],[105,143],[91,139],[80,142],[81,152],[76,163],[67,161],[59,149],[63,138],[24,173]];

   


//==========================================================================================

$sigmaSquare = pow(isset($_GET['sigma'])?$_GET['sigma']:5, 2);
$src_r0 = PointsHelper::multiplicateCoordinatesArray($src0, 4);
$resPoints0 = DP::run(PointsHelper::fromArrayToPoints($src_r0), $sigmaSquare);


//echo '<pre>';
$src_r1 = PointsHelper::multiplicateCoordinatesArray($src1, 4);
$src_points = PointsHelper::fromArrayToPoints($src_r1);
$resPoints1 = DP::run($src_points, $sigmaSquare);
$resPoints1_1 = VW::run($src_points, count($src_points) - count($resPoints1));

//echo "count 1: ".count($resPoints1).PHP_EOL;
//print_r($resPoints1);
//echo "count 2: ".count($resPoints1_1).PHP_EOL;
//
//print_r($resPoints1_1);
//die();
$src_r2 = PointsHelper::multiplicateCoordinatesArray($src2, 4);
$resPoints2 = DP::runWithoutRecursion(PointsHelper::fromArrayToPoints($src_r2), $sigmaSquare);
//$resPoints2 = DP::run(PointsHelper::fromArrayToPoints($src_r2), $sigmaSquare);

$image = new Image();
$image
//    ->addPoints(PointsHelper::fromPointsToArray($resPoints0), Image::RED)
//    ->addPoints($src_r0, Image::GREEN)
//        
    ->addPoints(PointsHelper::fromPointsToArray($resPoints1), Image::YELLOW)
    ->addPoints(PointsHelper::fromPointsToArray($resPoints1_1), Image::RED)
    ->addPoints($src_r1, Image::BLUE)
        
//    ->addPoints(PointsHelper::fromPointsToArray($resPoints2), 'one')
//    ->addPoints($src_r2, 'two')
    ->printImage()
;


