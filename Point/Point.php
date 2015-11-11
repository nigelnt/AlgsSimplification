<?php
namespace TestAlg\Points;

class Point
{
    private $x;
    private $y;
    
    public function __construct($x, $y) {
        if(!is_numeric($x) || !is_numeric($y))
        {
            throw new Exception('Incorrect input type');
        }
        
        $this->x = $x;
        $this->y = $y;
    }
    
    public function getX()
    {
        return $this->x;
    }
    
    public function getY()
    {
        return $this->y;
    }
    
    public function getCoordinates()
    {
        return [$this->getX(), $this->getY()];
    }
}

