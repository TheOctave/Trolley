<?php

class SphericalLine {
    
    public $_pointA;
    public $_pointB;
    
    public function __construct($pointA, $pointB) {
        
        $this->_pointA = $pointA;
        $this->_pointB = $pointB;
    }
}