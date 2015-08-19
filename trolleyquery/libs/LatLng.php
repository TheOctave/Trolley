<?php

class LatLng {
    
    public $_longitude;
    public $_latitude;
    
    public function LatLng($longitude, $latitude) {
        
        $this->_longitude = $longitude;
        $this->_latitude = $latitude;
    }
}