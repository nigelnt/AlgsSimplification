<?php

namespace TestAlg;

use \TestAlg\Points\Helper as PointsHelper;
use \TestAlg\Image\Image;
use \TestAlg\Algs\DP;
use \TestAlg\Algs\VW;

include 'conf.php';

$src = [[14,111],[18,114],[22,110],[25,106],[30,106],[37,108],[44,112],[48,115],[56,118],[57,195],[61,118],[69,119],[73,120],[82,120],[83,117],[88,113],[90,47],[92,112],[99,115],[104,114],[111,110],[113,101],[111,91],[112,84],[115,80],[190,77],[116,75],[117,67],[120,64],[117,56],[116,53],[115,46],[114,37],[110,31],[10,27],[56,22],[74,25],[89,22],[91,13],[107,22],[110,26],[115,21],[117,14]];
$src =  [ [0, 47.0489681], [0.8916692, 40.7740439], [1.8033758, 37.707202], [1.6297174, 35.5652824], [4.3893276, 30.6133378], [5.0572445, 23.7116675], [6.5556049, 17.9459426], [16.100138, 17.9738878], [29.1234052, 18.0170759], [36.6519424, 16.6096616], [41.5833958, 18.3422567], [47.8206269, 18.967216], [50.5958218, 18.2393674], [58.9458968, 18.30669], [63.1671319, 18.0081842], [63.1593395, 20.9221381], [66.8718445, 20.917057], [66.8440147, 25.4303822], [68.119736, 28.482966], [79.9351868, 29.0355636], [77.9447943, 31.2053255], [79.9485451, 31.7833418], [82.7415512, 37.8660052], [84.2721942, 38.6841625], [86.9972953, 41.6138171], [90.7242718, 41.6570128], [76.8193542, 10.0313412], [82.1727086, 10.0046679], [84.745302, 8.9224965], [89.3483629, 10.1329541], [113.0082075, 10.2129742], [122.2288009, 10.2968049], [131.7132215, 10.1494661], [151.3544325, 10.3425307], [153.4539181, 9.1180996], [154.2175698, 6.2386988], [154.1975323, 10.3628533], [177.6280587, 10.5013012], [181.9672925, 10.5063818], [211.6773514, 10.5190835], [211.7018417, 7.2979858], [214.5338095, 7.2814741], [214.4124713, 10.4708172], [219.2493031, 10.5914828], [219.3294532, 0.0114306], [224.1763038, 0], [228.5277827, 1.5202747], [228.4966132, 10.6219668], [230.3322716, 10.6575314], [260.8349253, 10.7718464], [266.1259407, 9.5029559], [267.3203988, 14.9837864], [266.3151838, 22.205111], [264.6465047, 23.7434247], [261.9971008, 23.5198537], [259.730636, 20.5842482], [257.6834705, 19.4308564], [255.1598577, 20.4114929], [254.1590954, 21.844353], [250.0569722, 17.5623321], [247.4431906, 17.0771044], [245.9537358, 20.3251153], [240.1417452, 23.4461769], [239.2066614, 25.770825], [235.5698537, 29.5792711], [232.8792616, 30.4570839], [231.2573366, 31.0427192], [229.5563748, 29.4941579], [226.7010298, 33.2811146], [226.7333125, 35.7329759], [223.3213701, 36.8001215], [216.78135, 40.0130438], [207.3848718, 45.2486608], [203.3551062, 44.13698], [200.6856648, 41.9403264], [194.8981645, 41.8209027], [193.2573152, 42.1397897], [191.8379917, 43.1244059], [187.2549683, 43.8244406], [179.5126977, 43.5538278], [174.6736394, 44.0112019], [171.6835979, 45.0542748], [172.1856488, 46.9625731], [173.8476488, 47.8150908], [170.5024981, 49.0043049], [169.8212228, 47.425041], [170.918833, 45.3757106], [166.0508317, 47.2027005], [163.1954867, 47.8189023], [152.4587219, 48.1034996], [147.3892322, 48.7781501], [142.4544392, 53.9480437], [139.4577185, 56.5985025], [135.6038377, 58.8081058], [129.5046428, 59.6619704], [126.506809, 60.4726386], [118.9671399, 65.9746406], [115.0364486, 67.016616], [112.0530863, 68.5973845], [111.4129992, 69.9672297], [109.8589791, 70.2417088], [111.1580776, 71.2150974], [108.9739892, 72.3486086], [107.1561419, 74.7440089], [99.8769604, 76.9412073], [95.9217789, 78.6695093], [89.7235096, 84.7479745], [88.886387, 86.0696933], [86.9449751, 87.1270778], [83.2046402, 86.212033], [80.1767501, 86.0696933], [74.7621701, 87.3507563], [68.599523, 88.081527], [67.1390113, 89.5252877], [66.8184112, 91.2537542], [67.9227005, 92.7788905], [70.9505907, 94.7310907], [71.9480133, 96.6833197], [71.9658244, 101.0352673], [73.6567675, 102.5668717], [75.1061473, 101.2119411], [75.1718258, 106.5262468], [73.4263362, 107.5227823], [70.8081017, 107.8888585], [66.337511, 109.2921599], [62.5259316, 109.5972274], [61.22572, 110.8175044], [61.3147756, 113.0343698], [63.0246429, 116.1652471], [65.8744219, 116.9584653], [65.6595753, 119.419506], [60.512162, 124.5858066], [58.6776168, 128.0233391], [59.3945144, 120.8725076], [56.8208077, 120.0068066], [55.6141044, 116.9749908], [53.5424487, 116.4804999], [53.0348318, 115.0720375], [51.385077, 116.6114318], [49.4982116, 114.0017178], [49.8065666, 112.0759269], [48.5853918, 111.0831704], [49.6073047, 107.8608943], [47.5712712, 105.0339997], [44.2305733, 101.1750811], [44.131499, 99.1045813], [41.903996, 95.8546356], [40.8386684, 93.4067434], [37.1217106, 90.7644434], [35.1580348, 90.7428375], [32.8715325, 89.6180651], [27.819854, 80.8400853], [23.6598446, 80.5617718], [23.6642974, 79.0126308], [21.2909658, 76.5180309], [18.4834883, 74.5749951], [17.5762344, 71.5937805], [13.7624287, 71.5162648], [11.5983778, 69.5110367], [8.5126015, 66.1893886], [5.87099, 62.2795064], [4.3425734, 60.8462084], [3.1225118, 58.5552511], [0.5721822, 50.8897903] ]; 

$src_array = PointsHelper::multiplicateCoordinatesArray($src, 4);
$src_points = PointsHelper::fromArrayToPoints($src_array);

$image = new Image();

$a = 255;

$image -> addPoints($src_array, Image::RED);	

for($i = 100; $i < 100000; $i +=$i)
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
