<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GeographicalPoint {
    
    public $_latitude;
    public $_longitude;
    
    public function __construct($lat, $long) {
        $this->_latitude = $lat;
        $this->_longitude = $long;
    }
}