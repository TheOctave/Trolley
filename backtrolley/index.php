<?php


$url = isset($_GET['url']) ? $_GET['url'] : 'error';
$url = rtrim($url, '/');

if ($url == 'login') {
    
    include 'work/login.php';
} else if ($url == 'coordinateUpdate') {
    
    //include 'work/poll.php';
    //include 'work/update.php';
} else if ($url == 'routeUpdate') {
    
    include 'work/route.php';
} else if ($url == 'logout') {
    
    include 'work/logout.php';
} else if ($url == 'simulator') {
    
    include 'simulator.php';
} else {
    
    echo json_encode(array('status' => 'failure'));
}