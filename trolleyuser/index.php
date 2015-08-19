<?php
$url = (isset($_GET['url'])) ? $_GET['url'] : 'index';
$url = rtrim($url, '/');
$urlArray = explode('/', $url);

if ($urlArray[0] == 'index' || $urlArray[0] == 'home') {
    include 'webpages/index.php';
}