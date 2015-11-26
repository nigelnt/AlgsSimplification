<?php

namespace TestAlg\Image;

class Image
{    
    private $imgWidth = 300;
    private $imgHeight = 300;
    
    private $colors = [];
    
    private $image;


    //['red'=>[[width, height], ...], ...]
    private $points = [];
    
    const RED       = 'red';
    const GREEN     = 'green';
    const YELLOW    = 'yellow';
    const BLUE      = 'blue';


    public function __construct() {
        return $this;
    }

    function addPoints($src, $color)
    {
        $this->points[$color] = [];
        foreach($src as $point)
        {
            if($point[0] > $this->imgWidth)
            {
                $this->imgWidth = $point[0];
            }

            if($point[1] > $this->imgHeight)
            {
                $this->imgHeight = $point[1];
            }
            
            $this->points[$color][] = $point;
        }
        
        return $this;
    }
    
    public function printImage()
    {
        header ('Content-Type: image/png');
        $this -> image = @imagecreatetruecolor($this->imgWidth, $this->imgHeight) or die('Unable to allocate GD stream');
        $this -> paintLines();
        imagepng($this -> image);
        imagedestroy($this -> image);
    }
    
    private function paintLines()
    {
        foreach ($this->points as $color=>$src)
        {
            $resColor = $this->generateColor($color);
            $this->addColorLine($src, $resColor);
        }
    }
    
    private function addColorLine($points, $color)
    {
        foreach($points as $key=>$point)
        {
            if(array_key_exists($key + 1, $points))
            {
                $nextPoint = $points[$key + 1];
                imageline(
                    $this -> image, 
                    $point[0], 
                    $this->imgHeight - $point[1], 
                    $nextPoint[0], 
                    $this->imgHeight - $nextPoint[1], 
                    $color
                );
            }

        }
    }
    
    private function generateColor($color)
    {
        if(array_key_exists($color, $this->colors))
        {
            return $this->colors[$color];
            $this->colors[$color] = imagecolorallocate ($this -> $image, $R, $G, $B);
        }
        
		switch ($color)
		{
			case self::RED:
					$this->colors[$color] = imagecolorallocate ($this -> image, 255, 0, 0);
				break;
			case self::GREEN:
					$this->colors[$color] = imagecolorallocate ($this -> image, 0, 255, 0);
				break;
			case self::YELLOW:
					$this->colors[$color] = imagecolorallocate ($this -> image, 255, 255, 0);
				break;
			case self::BLUE:                    
					$this->colors[$color] = imagecolorallocate ($this -> image, 0, 0, 255);
				break;
			default :                  
					$this->colors[$color] = imagecolorallocate ($this -> image, rand(50,200), rand(50,200), rand(50,200));
        }
        
        return $this->colors[$color];
    }
}
