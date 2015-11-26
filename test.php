<?php

namespace TestAlg;

use \TestAlg\Points\Helper as PointsHelper;
use \TestAlg\Image\Image;
use \TestAlg\Algs\DP;
use \TestAlg\Algs\VW;

include 'conf.php';
include 'src.php';

$src_array = isset($_REQUEST['src']) ? 'src'.$_REQUEST['src'] : 'src1';

$src = isset($$src_array) ? $$src_array : $src1;

$src_array = PointsHelper::multiplicateCoordinatesArray($src, 4);
$src_points = PointsHelper::fromArrayToPoints($src_array);

$image = new Image();

$a = 255;

$image -> addPoints($src_array, Image::RED);	

for($i = 100; $i < 10000; $i +=$i)
{
	dec($a);
	$DP =  DP::runWithoutRecursion($src_points, $i);
	$image->addPoints(PointsHelper::fromPointsToArray($DP), $a);	
}     

$image -> printImage();

function dec(&$color)
{
	if ($color > 128) $color -= 16;
	elseif ($color > 32) $color -=4;
	elseif ($color > 2) --$color;
}
