<?php

class SphericalPoint {
    
    public $_x;
    public $_y;
    
    public function __construct($x, $y, $z) {
        
        $this->_x = $x;
        $this->_y = $y;
        $this->_z = $z;
    }
}