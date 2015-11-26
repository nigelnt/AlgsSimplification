<?php

namespace TestAlg;

use \TestAlg\Points\Helper as PointsHelper;
use \TestAlg\Image\Image;
use \TestAlg\Algs\DP;
use \TestAlg\Algs\VW;

include 'conf.php';
//[[width,height],....]

include 'src.php';

//==========================================================================================

$sigmaSquare = pow(isset($_REQUEST['sigma'])?$_REQUEST['sigma']:5, 2);

$src_array = isset($_REQUEST['src']) ? 'src'.$_REQUEST['src'] : 'src0';
$src = isset($$src_array) ? $$src_array : $src0;

$src_array = PointsHelper::multiplicateCoordinatesArray($src, 4);
$src_points = PointsHelper::fromArrayToPoints($src_array);
$DP_points = DP::run($src_points, $sigmaSquare);
$VW_points = VW::run($src_points, count($src_points) - count($resPoints1));
$DP_points2 = DP::runWithoutRecursion($src_points, $sigmaSquare);

$image = new Image();
$image
    ->addPoints(PointsHelper::fromPointsToArray($VW_points), Image::YELLOW)
    ->addPoints(PointsHelper::fromPointsToArray($DP_points), Image::RED)
    ->addPoints(PointsHelper::fromPointsToArray($DP_points2), Image::GREEN)
    ->addPoints($src_array, Image::BLUE)
    
    ->printImage()
;
