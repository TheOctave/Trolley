<?php
include 'config.php';
$url = isset($_GET['url']) ? $_GET['url'] : 'error';
$url = rtrim($url, '/');

if ($url == 'query_eta') {
    
    include 'controls/eta.php';
} else if ($url == 'query_location') {
    
    include 'controls/location.php';
} else if ($url == 'query_stops') {
    
    include 'controls/stops.php';
}else if ($url == 'query_active') {
 
    include 'controls/active.php';
} else if ($url == 'query_all'){
    
    include 'controls/trolleys.php';
}else if ($url == 'linebreak') {
    
    include 'libs/GeographicalPoint.php';
    include 'libs/GeographicalLine.php';
    include 'libs/SphericalPoint.php';
    include 'libs/SphericalLine.php';
    include 'libs/Algorithm.php';
    include 'controls/linebreak.php';
}