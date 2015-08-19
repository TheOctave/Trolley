<?php


/**
 * Checks if chosen route is valid
 * @param String $route
 * @return boolean
 */
function isValidRoute($route) {
    
    return $route == 'campus' ||
            $route == 'extended' ||
            $route == 'nathanBisk' ||
            $route == 'downtown';
}

