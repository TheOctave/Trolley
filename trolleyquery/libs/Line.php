<?php
class Line {
    
    private $_a;
    private $_b;
    private $_c;
    private $pointA;
    private $pointB;
    
    function __construct($argA, $argB, $gradient = false) {
        
        if ($gradient) { //if gradient is set, then y-intercept is assumed to be set too
            
            /*
             * TODO - make check for valid m and c
             */
            
            /*
             * set the gradient and the y-intercept
             */
            //this is currently incorrect.
            $this->_a = 1;
            $this->_b = $argA;
            $this->_c = $argB;
        } else {
            
            /*
             * TODO - make check for valid point
             */
            
            /*
             * calculate the parameters a, b, c
             */
            $pointA = $argA;
            $pointB = $argB;

            if (abs($pointA->_x - $pointB->_x) <= Algorithm::EPSILON) {
                $this->_a = 1;
                $this->_b = 0;
                $this->_c = -$pointA->_x;
            } else {
                $this->_a = ($pointA->_y - $pointB->_y) / ($pointA->_x - $pointB->_x);
                $this->_b = 1.0;
                $this->_c = ($this->_a * $pointA.x) - $pointA->_y;
            }
            
        }
        
    }
}
