<?php
namespace TestAlg\Points;

use \TestAlg\Points\Point;

class PointsService
{
    public static function minimalLengthToLine(Point $point, Point $linePointA, Point $linePointB)
    {
        //    tPointA
        //  |\
        // c| \a
        //  |__\  tPointB
        //    b
        // point

        $tPointA = new Point($point->getX(), self::getYCoordinateForTriangle($point, $linePointA, $linePointB));
        $tPointB = new Point(self::getXCoordinateForTriangle($point, $linePointA, $linePointB), $point->getY());


        $aLength = self::getSquareDistance2Points($tPointA, $tPointB);
        $bLength = self::getSquareDistance2Points($point, $tPointB);
        $cLength = self::getSquareDistance2Points($point, $tPointA);

        // for paralel to coordinate lines 
        if($aLength === $cLength || $aLength === $bLength)
        {
            return $aLength;
        }

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
        return ($bLength * $cLength) / $aLength;
    }

    /**
     * 
     * @param Point $point 90 angle
     * @param Point $linePointA
     * @param Point $linePointB
     */
    public static function getXCoordinateForTriangle(Point $point, Point $linePointA, Point $linePointB)
    {
        // follow to line eypression
        // (x - x2) / (x1 - x2) = (y - y2) / (y1 - y2)
        // than
        // x = (((y - y1) / (y2 - y1)) * (x2 - x1)) + x1

        if($linePointA->getX() === $linePointB->getX())
        {
            return $linePointA->getX();
        }


        if($linePointA->getY() === $linePointB->getY())
        {
            return $point->getX();
        }

        return (
                    (
                        ($point->getY() - $linePointA->getY()) / 
                        ($linePointB->getY() - $linePointA->getY())
                    ) * 
                    (
                        $linePointB->getX() - $linePointA->getX()
                    )
                ) + $linePointA->getX();
    }

    /**
     * 
     * @param Point $point 90 angle
     * @param Point $linePointA
     * @param Point $linePointB
     */
    public static function getYCoordinateForTriangle(Point $point, Point $linePointA, Point $linePointB)
    {


        if($linePointA->getY() === $linePointB->getY())
        {
            return $linePointA->getY();
        }


        if($linePointA->getX() === $linePointB->getX())
        {
            return $point->getY();
        }

        return (
                    (
                        ($point->getX() - $linePointA->getX()) / 
                        ($linePointB->getX() - $linePointA->getX())
                    ) * 
                    (
                        $linePointB->getY() - $linePointA->getY()
                    )
                ) + $linePointA->getY();
    }

    public static function getSquareDistance2Points(Point $pointA, Point $pointB)
    {
        return pow(
                    $pointA->getX() - $pointB->getX(),
                    2
                ) + 
                pow(
                    $pointA->getY() - $pointB->getY(),
                    2
                );
    }
}

